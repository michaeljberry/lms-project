<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin->parents()->syncWithoutDetaching($userRole);

        $permissions = [
            'manage_roles',
            'manage_permissions',
            'manage_profiles',
        ];

        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm]);
            $admin->permissions()->syncWithoutDetaching($permission);
        }

        if ($user = User::first()) {
            $user->roles()->syncWithoutDetaching($admin);
        }
    }
}
