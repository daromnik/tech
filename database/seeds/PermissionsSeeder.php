<?php

use Illuminate\Database\Seeder;
//use Cartalyst\Sentinel\Roles\EloquentRole as Roles;
//use \Sentinel;

class PermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Set permissions to Admin's role
        $roleAdmin = Sentinel::findRoleBySlug("admin");
        $roleAdmin->permissions = [
            "user"            => true,
            "user.add"        => true,
            "user.edit"       => true,
            "user.delete"     => true,
            "projects"        => true,
            "projects.add"    => true,
            "projects.edit"   => true,
            "projects.delete" => true,
        ];
        $roleAdmin->save();

        /*// Create Manager's role
        Roles::create(
            array(
                'name' => 'Manager',
                'slug' => 'manager'
            )
        );

        // Create Optimizer's role
        Roles::create(
            array(
                'name' => 'Optimizer',
                'slug' => 'optimizer'
            )
        );

        // Create Client's role
        Roles::create(
            array(
                'name' => 'Client',
                'slug' => 'client'
            )
        );*/
    }
}
