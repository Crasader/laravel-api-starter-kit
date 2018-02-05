<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
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
    
    public function testLoginSuccessfully()
    {
        $this->post('api/auth/login', [
            'email'    => 'tester@test.com',
            'password' => '123456'
        ])
             ->assertJsonStructure([
                 'status',
                 'token',
                 'expires_in'
             ])
             ->assertJson([
                 'status' => 'success'
             ])
             ->isOk();
    }
    
    public function testLoginWithWrongCredentials()
    {
        $this->post('api/auth/login', [
            'email'    => 'test@test.com',
            'password' => '123456'
        ])
             ->assertJsonStructure([
                 'status',
                 'message'
             ])
             ->assertJson([
                 'status' => 'error'
             ])
             ->isOk();
    }
    
    public function testLoginWithValidationErrors()
    {
        $this->post('api/auth/login', [
            'email' => 'test@test.com'
        ])
             ->assertJsonStructure([
                 'status',
                 'message',
                 'errors'
             ])
             ->assertJson([
                 'status' => 'error'
             ])
             ->isOk();
    }
}
