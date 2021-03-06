<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Event;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserCreatedNotification;
use Illuminate\Support\Facades\Auth;

class UserRegistrationTest extends TestCase
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
            'password_confirmation' => 'pword'
        ]);
        $response->assertSessionHasErrors('name');
        $response->assertSessionHasInput('email', 'kay@email.com');
        $response->assertRedirect();
    }

    public function testThatEmailIsRequiredAtRegistration()
    {
        $response = $this->post('/user/register', [
            'name' => 'Ola',
            'email' => '',
            'password' => 'pword',
            'password_confirmation' => 'pword'
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasInput('name', 'Ola');
        $response->assertRedirect();
    }

    public function testThatEmailIsMustBeAValidEmail()
    {
        $response = $this->post('/user/register', [
            'name' => 'Ola',
            'email' => 'kunsal',
            'password' => 'pword',
            'password_confirmation' => 'pword'
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasInput('email', 'kunsal');
        $response->assertSessionHasInput('name', 'Ola');
        $response->assertRedirect();
    }

    public function testThatEmailIsMustBeUnique()
    {
        User::create([
            'name' => 'Ola',
            'email' => 'kunsal@email.com',
            'password' => 'pword',
            'password_confirmation' => 'pword'
        ]);
        $response = $this->post('/user/register', [
            'name' => 'Ola',
            'email' => 'kunsal@email.com',
            'password' => 'pword',
            'password_confirmation' => 'pword'
        ]);
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasInput('email', 'kunsal@email.com');
        $response->assertSessionHasInput('name', 'Ola');
        $response->assertRedirect();
    }

    public function testThatPasswordIsRequired()
    {
        $response = $this->post('/user/register', [
            'name' => 'Ola',
            'email' => 'kunsal@email.com',
            'password' => '',
            'password_confirmation' => 'pword'
        ]);
        $response->assertSessionHasErrors('password');
        $response->assertSessionHasInput('email', 'kunsal@email.com');
        $response->assertSessionHasInput('name', 'Ola');
        $response->assertRedirect();
    }

    public function testThatPasswordsShouldMatch()
    {
        $response = $this->post('/user/register', [
            'name' => 'Ola',
            'email' => 'kunsal@email.com',
            'password' => 'passwd',
            'password_confirmation' => 'pword'
        ]);
        $response->assertSessionHasErrors('password');
        $response->assertSessionHasInput('email', 'kunsal@email.com');
        $response->assertSessionHasInput('name', 'Ola');
        $response->assertRedirect();
    }

    public function testThatUserCanBeCreated()
    {
        $response = $this->post('/user/register', [
            'name' => 'Ola',
            'email' => 'kunsal@email.com',
            'password' => 'pword',
            'password_confirmation' => 'pword'
        ]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', [
            'name' => 'Ola',
            'email' => 'kunsal@email.com',
        ]);
        $response->assertSessionHas('success', 'Account created successfully');
        $response->assertRedirect('user/login');
    }

    public function testThatUserCreatedEventIsFired()
    {
        Event::fake();
        $response = $this->post('/user/register', [
            'name' => 'Ola',
            'email' => 'kunsal@email.com',
            'password' => 'pword',
            'password_confirmation' => 'pword'
        ]);
        Event::assertDispatched(UserCreated::class);
    }

    public function testThatMailIsSentToCreatedUser()
    {
        $this->withoutExceptionHandling();
        Notification::fake();
        $email = 'kunsal@email.com';
        $this->post('/user/register', [
            'name' => 'Ola',
            'email' => $email,
            'password' => 'pword',
            'password_confirmation' => 'pword'
        ]);
        $user = User::where('email', $email)->first();
        Notification::assertSentTo($user, UserCreatedNotification::class);
    }

    public function testThatLoggedInUserCanNotAccessRegistrationPage()
    {
        $user = User::create([
            'name' => 'Ola',
            'email' => 'kunsal@email.com',
            'password' => 'pword',
            'password_confirmation' => 'pword'
        ]);
        Auth::login($user);
        $response = $this->get('/user/register');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }


}
