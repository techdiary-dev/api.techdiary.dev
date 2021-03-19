<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AdminCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdminCrudController extends \Backpack\PermissionManager\app\Http\Controllers\UserCrudController
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
        parent::setup();

        CRUD::enableExportButtons();
        CRUD::setModel(\App\Models\Admin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/admin');
        CRUD::setEntityNameStrings('admin', 'admins');
    }

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run
        return $this->traitUpdate();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
//    protected function setupListOperation()
//    {
//        CRUD::column('name');
//        CRUD::column('email');
//        CRUD::column('password');
//
//        /**
//         * Columns can be defined using the fluent syntax or array syntax:
//         * - CRUD::column('price')->type('number');
//         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
//         */
//    }
//
//    /**
//     * Define what happens when the Create operation is loaded.
//     *
//     * @see https://backpackforlaravel.com/docs/crud-operation-create
//     * @return void
//     */
//    protected function setupCreateOperation()
//    {
//        CRUD::setValidation(AdminRequest::class);
//
//        CRUD::field('name');
//        CRUD::field('email');
//        CRUD::field('password');
//
//        /**
//         * Fields can be defined using the fluent syntax or array syntax:
//         * - CRUD::field('price')->type('number');
//         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
//         */
//    }
//
//    /**
//     * Define what happens when the Update operation is loaded.
//     *
//     * @see https://backpackforlaravel.com/docs/crud-operation-update
//     * @return void
//     */
//    protected function setupUpdateOperation()
//    {
//        $this->setupCreateOperation();
//    }
}
