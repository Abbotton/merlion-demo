<?php

namespace App\Providers;

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
                Route::resource('users', UserController::class);
            })
            ->menus([
                (new Menu())->label('用户管理')->icon('ti ti-users-group')->link(url('/admin/users'))
            ])
            ->path('admin');
    }
}
