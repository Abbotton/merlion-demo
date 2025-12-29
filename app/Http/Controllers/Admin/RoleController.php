<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Merlion\Http\Controllers\CrudController;

class RoleController extends CrudController
{
    protected string $model = Role::class;

    protected string $label = '角色';

    protected function schemas(): array
    {
        if (request()->routeIs('admin.roles.show')) {
            return [
                \Merlion\Components\Show\Grid\Text::make('name')->label('角色名称')->copyable(),
                \Merlion\Components\Show\Grid\Select::make('users')->label('关联用户')->relationship('users'),
                \Merlion\Components\Show\Grid\Select::make('permissions')->label('关联权限')->relationship('permissions'),
            ];
        }

        $permissions = Permission::pluck('name', 'id')->toArray();
        $users = User::pluck('name', 'id')->toArray();

        return [
            \Merlion\Components\Form\Fields\Text::make('name')
                ->label('角色名称')
                ->required()
                ->rules('required'),

            \Merlion\Components\Form\Fields\Select::make('_users')
                ->label('关联用户')
                ->options($users)
                ->value(function () {
                    return $this->current_model?->users->pluck('id')->toArray();
                })
                ->multiple(true),

            \Merlion\Components\Form\Fields\Select::make('_permissions')
                ->label('关联权限')
                ->options($permissions)
                ->value(function () {
                    return $this->current_model?->permissions->pluck('id')->toArray();
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
            \Merlion\Components\Table\Columns\Text::make('name')->label('角色名称')->copyable(),
            \Merlion\Components\Table\Columns\Select::make('users')->label('关联用户')->relationship('users'),
            \Merlion\Components\Table\Columns\Select::make('permissions')->label('关联权限')->relationship('permissions'),
        ];
    }
}
