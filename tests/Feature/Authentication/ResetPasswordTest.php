<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domains\Users\Models\User;
use Illuminate\Support\Facades\Password;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Class ResetPasswordTest
 *
 * @package Tests\Feature\Authentication
 */
class ResetPasswordTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  public function testUserCanResetPasswordWithValidToken(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'password' => bcrypt('old-password'),
    ]);

    $this->post('password/reset', [
      'token'                 => $this->getValidToken($user),
      'email'                 => $user->email,
      'password'              => 'new-awesome-password',
      'password_confirmation' => 'new-awesome-password',
    ])->assertStatus(Response::HTTP_OK);
  }

  public function testUserCannotResetPasswordWithInvalidToken(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'password' => bcrypt('old-password'),
    ]);

    $this->post('password/reset', [
      'token'                 => $this->getInvalidToken(),
      'email'                 => $user->email,
      'password'              => 'new-awesome-password',
      'password_confirmation' => 'new-awesome-password',
    ])->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
  }

  public function testUserCannotResetPasswordWithoutProvidingNewPassword(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'password' => bcrypt('old-password'),
    ]);

    $this->post('password/reset', [
      'token'                 => $this->getValidToken($user),
      'email'                 => $user->email,
      'password'              => '',
      'password_confirmation' => '',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testUserCannotResetPasswordWithoutProvidingAnEmail(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'password' => bcrypt('old-password'),
    ]);

    $this->post('password/reset', [
      'token'                 => $this->getValidToken($user),
      'email'                 => '',
      'password'              => 'new-awesome-password',
      'password_confirmation' => 'new-awesome-password',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  /**
   * Create a valid token.
   *
   * @param \App\Domains\Users\Models\User $user
   *
   * @return string
   */
  private function getValidToken(User $user): string
  {
    return Password::broker()->createToken($user);
  }

  /**
   * Return a invalid token.
   *
   * @return string
   */
  private function getInvalidToken(): string
  {
    return 'invalid-token';
  }
}
