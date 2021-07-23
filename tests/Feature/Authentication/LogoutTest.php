<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domains\Users\Models\User;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Class LogoutTest
 *
 * @package Tests\Feature\Authentication
 */
class LogoutTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  public function testUserCanLogout(): void
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

    $this->post('/logout')->assertStatus(Response::HTTP_OK);

    $this->assertGuest('api');
  }

  public function testUserCannotLogoutWhenNotAuthenticated(): void
  {
    $this->post('/logout')->assertStatus(Response::HTTP_UNAUTHORIZED);

    $this->assertGuest('api');
  }

  public function testUserCannotMakeMoreThanFiveAttemptsInOneMinute(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'password' => bcrypt($password = 'i-love-laravel'),
    ]);

    $response = NULL;

    foreach (range(0, 5) as $_) {
      $response = $this->post('/login', [
        'email'    => $user->email,
        'password' => 'invalid-password',
      ]);
    }

    $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);

    $this->assertGuest('api');
  }
}
