<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Domains\Users\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Auth\Notifications\ResetPassword;

/**
 * Class ForgotPasswordTest
 *
 * @package Tests\Feature\Authentication
 */
class ForgotPasswordTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  public function testUserReceivesAnEmailWithPasswordResetLink(): void
  {
    $this->runDatabaseMigrations();

    Notification::fake();

    $user = factory(User::class)->create();

    $this->post('/password/email', [
      'email' => $user->email,
    ])->assertStatus(Response::HTTP_OK);

    $token = DB::table('password_resets')
      ->where('email', '=', $user->email)
      ->first();

    $this->assertNotNull($token);

    $this->assertDatabaseHas('password_resets', [
      'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($token) {
      return Hash::check($notification->token, $token->token);
    });
  }

  public function testUserDoesNotReceiveEmailWhenNotRegistered(): void
  {
    $this->runDatabaseMigrations();

    Notification::fake();

    $this->post('/password/email', [
      'email' => 'nobody@example.com',
    ])->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

    Notification::assertNotSentTo(factory(User::class)->make([
      'email' => 'nobody@example.com',
    ]), ResetPassword::class);
  }

  public function testEmailIsRequired(): void
  {
    $this->post('/password/email', [
      'email' => '',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson([
        'error' => [
          'status'  => 422,
          'message' => 'The given data was invalid.',
          'errors'  => [
            'email' => [
              0 => 'The email field is required.',
            ],
          ],
        ],
      ]);
  }

  public function testEmailIsAValidEmail(): void
  {
    $response = $this->post('/password/email', [
      'email' => 'invalid-email',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson([
        'error' => [
          'status'  => 422,
          'message' => 'The given data was invalid.',
          'errors'  => [
            'email' => [
              0 => 'The email must be a valid email address.',
            ],
          ],
        ],
      ]);
  }
}
