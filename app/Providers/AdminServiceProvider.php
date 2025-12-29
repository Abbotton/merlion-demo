<?php

namespace App\Providers;

use App\Form\Fields\ColorCheckbox;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Pages\Dashboard;
use Illuminate\Support\Facades\Route;
use Merlion\AdminProvider;
use Merlion\Components\Form\Fields\Field;
use Merlion\Components\Layouts\Admin;
use Merlion\Components\Menu;

class AdminServiceProvider extends AdminProvider
{
    public function boot(): void
    {
        Field::$fieldsMap['colorCheckbox'] = ColorCheckbox::class;
    }

    public function admin(Admin $admin): Admin
    {
        $admin->brandName = 'Merlion Demo';

        return $admin
            ->id('admin')
            ->default()
            ->home(Dashboard::class)
            ->authenticatedRoutes(function () {
                return [
                    Route::middleware('role:管理员')->group(function () {
                        Route::resource('users', UserController::class);
                        Route::resource('roles', RoleController::class);
                        Route::resource('permissions', PermissionController::class);
                    }),
                    Route::resource('posts', PostController::class)->middleware('role:管理员|编辑'),
                ];
            })
            ->menus([
                (new Menu())->label('用户管理')->icon('ti ti-users-group')->link(url('/admin/users')),
                (new Menu())->label('角色管理')->icon('ti ti-user-circle')->link(url('/admin/roles')),
                (new Menu())->label('权限管理')->icon('ti ti-lock')->link(url('/admin/permissions')),
                (new Menu())->label('文章管理')->icon('ti ti-list')->link(url('/admin/posts'))
            ])
            ->path('admin');
    }
}
