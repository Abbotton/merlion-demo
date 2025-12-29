<?php

namespace App\Models;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    protected static function booted(): void
    {
        static::saving(function (Role $role) {
            unset($role->_users);
            unset($role->_permissions);

            return $role;
        });

        static::saved(function (Role $role) {
            if (request()->has('_permissions')) {
                $role->permissions()->sync(request('_permissions'));
            }
            if (request()->has('_users')) {
                $role->users()->sync(request('_users'));
            }
        });
    }
}
