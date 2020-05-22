<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testThatUserCanAccessLoginPage()
    {
        $response = $this->get('/user/login');
        $response->assertStatus(200);
        $response->assertViewIs('user.login');
    }

    public function testThatEmailIsRequiredAtLogin()
    {
        $response = $this->post('/user/login', [
            'email' => '',
            'password' => 'pword'
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertRedirect();
    }

    public function testThatPasswordIsRequired()
    {
        $response = $this->post('/user/login', [
            'email' => 'kunsal@email.com',
            'password' => ''
        ]);
        $response->assertSessionHasErrors('password');
        $response->assertRedirect();
    }

    public function testThatUnregisteredUserCanNotLogin()
    {
        $this->withoutExceptionHandling();
        User::create([
            'name' => 'Olakunle',
            'email' => 'kunsal@email.com',
            'password' => 'passw'
        ]);

        $response = $this->post('/user/login', [
            'email' => 'kunsal@email.co',
            'password' => 'passw'
        ]);
        $response->assertSessionHasErrors();
        $response->assertSessionHasInput('email', 'kunsal@email.co');
        $response->assertRedirect();
    }

    public function testThatRegisteredUserCanLogin()
    {
        User::create([
            'name' => 'Olakunle',
            'email' => 'kunsal@email.com',
            'password' => 'passw'
        ]);

        $response = $this->post('/user/login', [
            'email' => 'kunsal@email.com',
            'password' => 'passw'
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $response->assertRedirect();
    }

    public function testThatUserCanLogout()
    {
        $this->get('logout')
            ->assertRedirect('/user/login');
    }

}
