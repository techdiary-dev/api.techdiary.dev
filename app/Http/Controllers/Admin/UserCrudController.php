<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Auth\RegisterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::column('username');
        CRUD::column('email');
        CRUD::column('profilePhoto')->type('image');
        CRUD::column('education');
        CRUD::column('designation');
        CRUD::column('bio');
        CRUD::column('website_url');
        CRUD::column('location');
        CRUD::column('social_links');
        CRUD::column('profile_readme');
        CRUD::column('skills');
        CRUD::column('password');
        CRUD::column('email_verified_at');
        CRUD::column('remember_token');
        CRUD::column('created_at');
        CRUD::column('updated_at');
        CRUD::column('socialProviders')->label('Github UID');

        $this->crud->enableExportButtons();

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RegisterRequest::class);

//        CRUD::field('id');

        CRUD::field('name');
        CRUD::field('username');
        CRUD::field('email');
        CRUD::field('profilePhoto');
        CRUD::field('education');
        CRUD::field('designation');
        CRUD::field('bio');
        CRUD::field('website_url');
        CRUD::field('location');
//        CRUD::field('social_links');
        $this->crud->addField([
            'name' => 'profile_readme',
            'type' => 'easymde',
        ]);
        CRUD::field('skills');
        CRUD::field('password');
        $this->crud->field('socialProviders');
        CRUD::field('email_verified_at');
        CRUD::field('remember_token');
        CRUD::field('created_at')->type('datetime');
        CRUD::field('updated_at')->type('datetime');

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
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
