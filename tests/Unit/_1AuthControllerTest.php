<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class _1AuthControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @return void
     * @test
    */

    public function login_form(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }

}
