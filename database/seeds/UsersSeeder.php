<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 10)
            ->create()
            ->each(function ($user) {
                $user->roles()->sync($this->getRoleId());
            });
    }

    private function getRoleId()
    {
        return Role::all("id")->random()->id;
    }
}
