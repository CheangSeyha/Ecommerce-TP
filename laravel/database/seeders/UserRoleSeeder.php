<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        // Get all permissions
        $allPermissions = Permission::all();
        $userManagePermission = Permission::where('name', 'users.manage')->first();
        $productPermissions = Permission::whereIn('name', [
            'products.create',
            'products.update',
            'products.delete',
        ])->get();
        $categoryPermissions = Permission::whereIn('name', [
            'category.create',
            'category.update',
            'category.delete',
        ])->get();

        // Assign permissions to roles
        // Admin has all permissions
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Manager has product and category permissions
        $managerRole->permissions()->sync(
            $productPermissions->merge($categoryPermissions)->pluck('id')
        );

        // Staff has no permissions by default
        $staffRole->permissions()->sync([]);

        // Assign roles to users
        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->roles()->sync([$adminRole->id]);
        }

        $managerUser = User::where('email', 'manager@example.com')->first();
        if ($managerUser) {
            $managerUser->roles()->sync([$managerRole->id]);
        }

        $staffUser1 = User::where('email', 'staff1@example.com')->first();
        if ($staffUser1) {
            $staffUser1->roles()->sync([$staffRole->id]);
        }

        $staffUser2 = User::where('email', 'staff2@example.com')->first();
        if ($staffUser2) {
            $staffUser2->roles()->sync([$staffRole->id]);
        }
    }
}
