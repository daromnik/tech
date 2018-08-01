<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Roles\EloquentRole as Roles;

class RolesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin's role
        Roles::create(
            array(
                'name' => 'Admin',
                'slug' => 'admin'
            )
        );

        // Create Manager's role
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
        );
    }
}
