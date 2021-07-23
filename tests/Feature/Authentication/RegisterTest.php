<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Class RegisterTest
 *
 * @package Tests\Feature\Authentication
 */
class RegisterTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  public function testUserCanRegister(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/register', $data = [
      'name'                  => $this->faker->name,
      'email'                 => $this->faker->safeEmail,
      'password'              => 'i-love-laravel',
      'password_confirmation' => 'i-love-laravel',
    ])->assertStatus(Response::HTTP_CREATED);

    $this->assertDatabaseHas('users', [
      'name'  => $data['name'],
      'email' => $data['email'],
    ]);
  }

  public function testUserCannotRegisterWithoutEmail(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/register', [
      'name'                  => $this->faker->name,
      'email'                 => '',
      'password'              => 'i-love-laravel',
      'password_confirmation' => 'i-love-laravel',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    $this->assertGuest('api');
  }

  public function testUserCannotRegisterWithInvalidEmail(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/register', [
      'name'                  => $this->faker->name,
      'email'                 => 'invalid-email',
      'password'              => 'i-love-laravel',
      'password_confirmation' => 'i-love-laravel',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    $this->assertGuest('api');
  }

  public function testUserCannotRegisterWithoutPassword(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/register', [
      'name'                  => $this->faker->name,
      'email'                 => $this->faker->safeEmail,
      'password'              => '',
      'password_confirmation' => '',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    $this->assertGuest('api');
  }

  public function testUserCannotRegisterWithoutPasswordConfirmation(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/register', [
      'name'                  => $this->faker->name,
      'email'                 => $this->faker->safeEmail,
      'password'              => 'i-love-laravel',
      'password_confirmation' => '',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    $this->assertGuest('api');
  }

  public function testUserCannotRegisterWithPasswordsNotMatching(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/register', [
      'name'                  => $this->faker->name,
      'email'                 => $this->faker->safeEmail,
      'password'              => 'i-love-laravel',
      'password_confirmation' => 'i-love-php',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    $this->assertGuest('api');
  }
}
