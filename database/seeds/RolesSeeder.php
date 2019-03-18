<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = Role::create([
            'name'        => 'Administrator',
            'slug'        => 'administrator',
            'permissions' => json_encode([
                'role-permission' => true,
                'create-data' => true,
                'update-data' => true,
                'show-data' => true,
                'delete-data' => true,
                'module-data' => true,
            ]),
        ]);
        $editor = Role::create([
            'name'        => 'Editor',
            'slug'        => 'editor',
            'permissions' => json_encode([
                'role-permission' => true,
                'create-data' => true,
                'update-data' => true,
                'show-data' => true,
                'delete-data' => false,
                'module-data' => true,
            ]),
        ]);
        $operator = Role::create([
            'name'        => 'Operator',
            'slug'        => 'operator',
            'permissions' => json_encode([
                'role-permission' => true,
                'create-data' => true,
                'update-data' => true,
                'show-data' => true,
                'delete-data' => false,
                'module-data' => false,
            ]),
        ]);

    }
}
