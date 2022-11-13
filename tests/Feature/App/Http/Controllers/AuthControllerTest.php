<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_success(): void
    {
        $this->get(action([AuthController::class, 'loginForm']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_register_page_success(): void
    {
        $this->get(action([AuthController::class, 'registerForm']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.register');
    }

    public function test_is_register_success(): void
    {
        Notification::fake();
        Event::fake();

        $this->withoutMiddleware();

        $request = [
            'name' => 'Ivan',
            'email' => 'ivan@ex.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(
            action([AuthController::class, 'register']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        $user = User::query()->where('email', $request['email'])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }

    public function test_is_login_success()
    {
        $this->withoutMiddleware();

        $password = 'test1234';

        $user = User::factory()->create([
            'email' => 'test_test@ex.com',
            'password' => bcrypt($password)
        ]);

        $request = [
            'email' => $user->email,
            'password' => $password
        ];

        $response = $this->post(
            action([AuthController::class, 'login']),
            $request
        );

        $response->assertValid();

        // TODO error on redirect

        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_success()
    {
        $user = User::factory()->create([
            'email' => 'test_test@ex.com',
        ]);

        $this->actingAs($user)
            ->delete(action([AuthController::class, 'logout']));

        $this->assertGuest();
    }


}
