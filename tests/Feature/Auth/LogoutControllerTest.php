<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    public function setUp()
    {
        parent::setUp();
        
        $user = new User([
            'name'     => 'Tester',
            'email'    => 'tester@test.com',
            'password' => '123456'
        ]);
        
        $user->save();
    }
    
    public function testLogout()
    {
        $response = $this->post('api/auth/login', [
            'email'    => 'tester@test.com',
            'password' => '123456'
        ]);
        
        $response->assertStatus(200);
        
        $responseJSON = json_decode($response->getContent(), true);
        $token        = $responseJSON['token'];
        
        $this->post('api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ])
             ->assertStatus(200);
        
        $this->post('api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ])
             ->assertStatus(400);
    }
}
