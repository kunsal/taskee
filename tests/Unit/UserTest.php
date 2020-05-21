<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testThatUserCanAccessRegistrationPage()
    {
        $response = $this->get('/user/register');
        $response->assertStatus(200);
        $response->assertViewIs('user.register');
    }

    public function testThatNameIsRequiredAtRegistration()
    {
        $response = $this->post('/user/register', [
            'name' => '',
            'email' => 'kay@email.com',
            'password' => 'pword',
            'password' => 'pword'
        ]);
        $response->assertSessionHasErrors('name');
        $response->assertRedirect();
    }

    // public function testThatNameLengthShouldBeMoreThanOne()
    // {
    //     $response = $this->post('/user/register'. [
    //         'name' => 'a'
    //     ]);
    //     $response->assertSessionHasErrors('name');
    //     $response->assertStatus(302);
    //     $response->assertRedirect();
    // }


}
