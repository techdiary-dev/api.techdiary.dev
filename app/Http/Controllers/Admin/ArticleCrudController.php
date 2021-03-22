<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Tag;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article');
        CRUD::setEntityNameStrings('article', 'articles');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $this->crud->addFilter([
            'type' => 'select2',
            'label' => 'Publish status',
            'name' => 'isPublished'
        ], function () {
            return [
                true => 'Published',
                false => 'Drafted',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'isPublished', $value);
        });

        $this->crud->addFilter([
            'type' => 'select2',
            'label' => 'Approval status',
            'name' => 'isApproved'
        ], function () {
            return [
                true => 'Approved',
                false => 'Pending',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'isApproved', $value);
        });
        // select2_multiple filter
        $this->crud->addFilter([
            'name' => 'tags',
            'type' => 'select2_multiple',
            'label' => 'Tags'
        ], function () { // the options that show up in the select2
            return Tag::all()->pluck('name', 'id')->toArray();
        }, function ($values) { // if the filter is active
            foreach (json_decode($values) as $key => $value) {
                $this->crud->query = $this->crud->query->whereHas('tags', function ($query) use ($value) {
                    $query->where('tag_id', $value);
                });
            }
        });

        $this->crud->column('title');
        $this->crud->column('thumbnail')->type('image');
        $this->crud->column('isPublished')->type('check');
        $this->crud->column('isApproved')->type('check');
        $this->crud->column('created_at');
        $this->crud->column('updated_at');


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }


    public function crudOperation()
    {
        CRUD::field('title');
        CRUD::field('slug');
        CRUD::field('thumbnail');
        CRUD::field('tags');

        $this->crud->addField([
            "name" => "body",
            "type" => "editorjs"
        ]);


        CRUD::field('excerpt');
        CRUD::field('isPublished');
        CRUD::field('isApproved');
        CRUD::field('user_id');
        CRUD::field('created_at');
        CRUD::field('updated_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CreateArticleRequest::class);
        $this->crudOperation();
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UpdateArticleRequest::class);
        $this->crudOperation();
    }
}
