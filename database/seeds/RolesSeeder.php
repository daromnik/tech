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
                'slug' => 'admin',
                'permissions' => '{"users":true,"users.create":true,"users.{user}":true,"users.{user}.edit":true,"roles":true,"roles.create":true,"roles.{role}":true,"roles.{role}.edit":true,"projects":true,"projects.create":true,"projects.{project}":true,"projects.{project}.edit":true,"groups":true,"groups.create":true,"groups.{group}":true,"groups.{group}.edit":true,"indicators":true,"indicators.create":true,"indicators.{indicator}":true,"indicators.{indicator}.edit":true,"queries.load":true,"settings":true}',
            )
        );

        // Create Manager's role
        Roles::create(
            array(
                'name' => 'Manager',
                'slug' => 'manager',
            )
        );

        // Create Optimizer's role
        Roles::create(
            array(
                'name' => 'Optimizer',
                'slug' => 'optimizer',
            )
        );

        // Create Client's role
        Roles::create(
            array(
                'name' => 'Client',
                'slug' => 'client',
            )
        );
    }
}
