<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testRegisterSuccessfully()
    {
        $this->post('api/auth/register', [
            'name'     => 'Tester',
            'email'    => 'tester@test.com',
            'password' => '123456'
        ])
             ->assertJsonStructure([
                 'status',
                 'token',
                 'expires_in'
             ])
             ->assertJson([
                 'status' => 'success',
             ])
             ->isOk();
    }
    
    public function testRegisterWithValidationErrors()
    {
        $this->post('api/auth/register', [
            'name'  => 'Tester',
            'email' => 'tester@test.com'
        ])
             ->assertJsonStructure([
                 'status',
                 'message',
                 'errors'
             ])
             ->assertJson([
                 'status' => 'error',
             ])
             ->isOk();
    }
}
