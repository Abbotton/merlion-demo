<?php

namespace App\Providers;

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Merlion\AdminProvider;
use Merlion\Components\Layouts\Admin;
use Merlion\Components\Menu;

class AdminServiceProvider extends AdminProvider
{
    public function admin(Admin $admin): Admin
    {
        $admin->brandName = 'Merlion Demo';

        return $admin
            ->id('admin')
            ->default()
            ->authenticatedRoutes(function () {
                return [
                    Route::resource('users', UserController::class),
                    Route::resource('roles', RoleController::class),
                    Route::resource('permissions', PermissionController::class),
                ];
            })
            ->menus([
                (new Menu())->label('用户管理')->icon('ti ti-users-group')->link(url('/admin/users')),
                (new Menu())->label('角色管理')->icon('ti ti-user-circle')->link(url('/admin/roles')),
                (new Menu())->label('权限管理')->icon('ti ti-lock')->link(url('/admin/permissions'))
            ])
            ->path('admin');
    }
}
