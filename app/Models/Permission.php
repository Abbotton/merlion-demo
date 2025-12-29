<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    protected static function booted(): void
    {
        static::saving(function (Permission $permission) {
            unset($permission->_users);
            unset($permission->_roles);

            return $permission;
        });

        static::saved(function (Permission $permission) {
            if (request()->has('_roles')) {
                $permission->roles()->sync(request()->input('_roles'));
            }
            if (request()->has('_users')) {
                $permission->users()->sync(request()->input('_users'));
            }
        });
    }
}
