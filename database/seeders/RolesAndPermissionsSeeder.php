<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $addUser = "add user";
        $updateUser = "update user";
        $deleteUser = "delete user";
        
        $addStudent = "add student";
        $updateStudent = "update student";
        $deleteStudent = "delete student";

        $admin = "admin";
        $teacher = "teacher"; 

        Permission::create(['name' => $addUser]);
        Permission::create(['name' => $updateUser]);
        Permission::create(['name' => $deleteUser]);

        Permission::create(['name' => $addStudent]);
        Permission::create(['name' => $updateStudent]);
        Permission::create(['name' => $deleteStudent]);

        Role::create(['name' => $admin])->givePermissionsTo(Permission::all());
        Role::create(['name' => $teacher])->givePermissionsTo([
            $addUser,
            $updateUser,
            $addStudent,
            $updateStudent,
        ]);

    }
}
