<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->command->info('Таблица Roles заполнена данными!');

        $this->call(UsersSeeder::class);
        $this->command->info('Таблица Users заполнена данными!');
    }
}
