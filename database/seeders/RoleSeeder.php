<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin =Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'admin']);

        $role_admin->givePermissionTo($permission);
    }
}
