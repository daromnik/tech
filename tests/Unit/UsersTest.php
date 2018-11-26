<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    //use DatabaseTransactions;

    public function testSeeUsersTable()
    {
        $this->assertDatabaseHas("users", ["email" => "daromnik@yandex.ru"]);
    }

    /*public function testCreateUser()
    {
        $user = factory(User::class)->create(["name" => "John Bongovy"]);

        $this->assertDatabaseHas("users", ["name" => "John Bongovy"]);

        $user->delete();
    }*/

    public function setUp()
    {
        parent::setUp(); // performs set up

        Session::start(); // starts session, this is what handles csrf token part

    }

    public function testDeleteUser()
    {
        $this->withoutMiddleware(
            [\App\Http\Middleware\IsLogin::class,
            \App\Http\Middleware\IsRightPermissions::class]
        );

        $user = factory(User::class)->create(["name" => "Peter II"]);

        $this->assertDatabaseHas("users", ["name" => "Peter II"]);

        $this->delete("users/{$user->id}", ['_token' => csrf_token()]);

        $this->assertDatabaseMissing("users", ["name" => "Peter II"]);

    }

//    public function testException()
//    {
//        $this->expectException(Exception::class);
//    }
}
