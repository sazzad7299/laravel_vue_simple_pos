<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Custom Permissions
        //name=Permission Name
        //display_name=Permission Display Name
        //module=Module Name
        //description=Permission Description
        //type=Permission Type (1=View, 2=Insert, 3=edit, 4=status, 5=delete,6=Detail View)

        //if description === MODULE than it is a module
        //if description === FEATURE than it is a feature of module
        //if display_name === description is for grouping of permissions
        $permissions = [

            // Pharmecy Base RBAC Access Control Module
            [
                'name' => 'rbac',
                'display_name' => 'RBAC',
                'module' => null,
                'description' => 'MODULE',
                'type' => null,
            ],
            //Role
            [
                'name' => 'role',
                'display_name' => 'Role',
                'module' => 'RBAC',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'role.index',
                'display_name' => 'Role List',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 1,
            ],
            [
                'name' => 'role.create',
                'display_name' => 'Role Insert',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 2,
            ],
            [
                'name' => 'role.edit', //these names comes from route.js
                'display_name' => 'Role Edit',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 3,
            ],
            [
                'name' => 'role.delete',
                'display_name' => 'Role Delete',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 5,
            ],
            [
                'name' => 'role.view',
                'display_name' => 'Role View',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 6,
            ],
            [
                'name' => 'role.assign-permission',
                'display_name' => 'Assign Permission',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 6,
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'module' => 'User',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Employee Feature wise Permission
            [
                'name' => 'user.index',
                'display_name' => 'List',
                'module' => 'User',
                'description' => 'User',
                'type' => 1,
            ],
            [
                'name' => 'user.create',
                'display_name' => 'Create',
                'module' => 'User',
                'description' => 'User',
                'type' => 2,
            ],
            [
                'name' => 'user.edit', //these names comes from route.js
                'display_name' => 'Edit',
                'module' => 'User',
                'description' => 'User',
                'type' => 3,
            ],
            [
                'name' => 'user.delete',
                'display_name' => 'Delete',
                'module' => 'User',
                'description' => 'User',
                'type' => 5,
            ],
           
        ];
        foreach ($permissions as $permissionData) {
            // find or create a permission with the same name
            Permission::firstOrCreate(['name' => $permissionData['name']], $permissionData);
        }
    }
}