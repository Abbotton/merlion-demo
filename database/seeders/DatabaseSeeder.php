<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $user = User::create([
            'name' => 'Test',
            'email' => 'test@admin.com',
            'password' => bcrypt('password'),
        ]);

        $adminRole = Role::create(['name' => '管理员']);
        $admin->assignRole($adminRole);

        $editorRole = Role::create(['name' => '编辑']);
        $postPermissions = Permission::create(['name' => '文章.*']);
        $postPermissions->assignRole($editorRole);
        $user->assignRole($editorRole);
    }
}
