<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Merlion\Http\Controllers\CrudController;

class PermissionController extends CrudController
{
    protected string $model = Permission::class;

    protected string $label = '权限';

    protected function schemas(): array
    {
        if (request()->routeIs('admin.permissions.show')) {
            return [
                \Merlion\Components\Show\Grid\Text::make('name')->label('权限名称')->copyable(),
                \Merlion\Components\Show\Grid\Select::make('users')->label('关联用户')->relationship('users'),
                \Merlion\Components\Show\Grid\Select::make('roles')->label('关联角色')->relationship('roles'),
            ];
        }
        $users = User::pluck('name', 'id')->toArray();
        $roles = Role::pluck('name', 'id')->toArray();

        return [
            \Merlion\Components\Form\Fields\Text::make('name')
                ->label('权限名称')
                ->rules('required|unique:permissions,name,'.request()->route('permission'))
                ->required(),

            \Merlion\Components\Form\Fields\Select::make('_roles')
                ->label('关联角色')
                ->options($roles)
                ->value(function () {
                    return $this->current_model?->roles->pluck('id')->toArray();
                })
                ->multiple(true),

            \Merlion\Components\Form\Fields\Select::make('_users')
                ->label('关联用户')
                ->options($users)
                ->value(function () {
                    return $this->current_model?->users->pluck('id')->toArray();
                })
                ->multiple(true),
        ];
    }

    protected function searches(): array
    {
        return ['name'];
    }

    protected function columns(): array
    {
        return [
            \Merlion\Components\Table\Columns\Text::make('id')->label('ID')->sortable(),
            \Merlion\Components\Table\Columns\Text::make('name')->label('权限名称')->copyable(),
            \Merlion\Components\Table\Columns\Select::make('roles')->label('关联角色')->relationship('roles'),
            \Merlion\Components\Table\Columns\Select::make('users')->label('关联用户')->relationship('users'),
        ];
    }
}
