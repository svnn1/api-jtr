<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domains\Users\Models\User;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Class LoginTest
 *
 * @package Tests\Feature\Authentication
 */
class LoginTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  public function testUserCanLoginWithCorrectCredentials(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'password' => bcrypt($password = 'i-love-laravel'),
    ]);

    $this->post('/login', [
      'email'    => $user->email,
      'password' => $password,
    ])->assertStatus(Response::HTTP_CREATED);

    $this->assertAuthenticated('api');
    $this->assertAuthenticatedAs($user, 'api');
  }

  public function testUserCannotLoginWithIncorrectPassword(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create();

    $response = $this->post('/login', [
      'email'    => $user->email,
      'password' => 'invalid-password',
    ])->assertStatus(Response::HTTP_UNAUTHORIZED);

    $response->assertStatus(401)->assertJson([
      'error' => [
        'message' => "These credentials do not match our records.",
      ],
    ]);

    $this->assertGuest('api');
  }

  public function testUserCannotLoginWithEmailThatDoesNotExist(): void
  {
    $this->runDatabaseMigrations();

    $response = $this->post('/login', [
      'email'    => 'silvano@svndev.com.br',
      'password' => 'invalid-password',
    ])->assertStatus(Response::HTTP_UNAUTHORIZED);

    $response->assertStatus(401)->assertJson([
      'error' => [
        'message' => "These credentials do not match our records.",
      ],
    ]);

    $this->assertGuest('api');
  }
}
