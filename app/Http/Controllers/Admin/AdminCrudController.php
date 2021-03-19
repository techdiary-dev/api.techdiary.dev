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

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
//        $request->request->remove('password_confirmation');
//        $request->request->remove('roles_show');
//        $request->request->remove('permissions_show');
//
//        // Encrypt password if specified.
//        if ($request->input('password')) {
//            $request->request->set('password', Hash::make($request->input('password')));
//        } else {
//            $request->request->remove('password');
//        }
//
//        return $request;
    }
}
