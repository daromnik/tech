<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndicatorTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListIndicators()
    {
        $user = \App\Models\User::find(1);

        //$user = factory(App\User::class)->create();

        $response = $this->actingAs($user)->get('/indicators');
           // ->see('FUCK');
        //$response = $this->get('/indicators');

        $response->assertStatus(200);



    }
}
