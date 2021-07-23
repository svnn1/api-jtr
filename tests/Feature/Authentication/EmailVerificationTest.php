<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domains\Users\Models\User;
use Illuminate\Support\Facades\URL;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Auth\Notifications\VerifyEmail;

/**
 * Class EmailVerificationTest
 *
 * @package Tests\Feature\Authentication
 */
class EmailVerificationTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  private string $verificationVerifyRouteName = 'verification.verify';

  private string $verificationResendRouteName = 'verification.resend';

  public function testUserCannotVerifyOthers(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'email_verified_at' => NULL,
    ]);

    $user2 = factory(User::class)->create([
      'email_verified_at' => NULL,
    ]);

    $this->actingAs($user, 'api')
      ->get($this->validVerificationVerifyRoute($user2))
      ->assertStatus(Response::HTTP_FORBIDDEN);

    $this->assertFalse($user2->fresh()->hasVerifiedEmail());
  }

  public function testForbiddenIsReturnedWhenSignatureIsInvalidInVerificationVerifyRoute(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'email_verified_at' => now(),
    ]);

    $this->actingAs($user, 'api')
      ->get($this->invalidVerificationVerifyRoute($user))
      ->assertStatus(Response::HTTP_FORBIDDEN);
  }

  public function testUserCanVerifyThemselves(): void
  {
    $this->runDatabaseMigrations();

    $user = factory(User::class)->create([
      'email_verified_at' => NULL,
    ]);

    $this->actingAs($user, 'api')
      ->get($this->validVerificationVerifyRoute($user))
      ->assertStatus(Response::HTTP_OK);

    $this->assertNotNull($user->fresh()->email_verified_at);
  }

  public function testGuestCannotResendVerificationEmail()
  {
    $this->get($this->verificationResendRoute())
      ->assertStatus(Response::HTTP_UNAUTHORIZED);
  }

  public function testUserCanResendAVerificationEmail(): void
  {
    $this->runDatabaseMigrations();

    Notification::fake();

    $user = factory(User::class)->create([
      'email_verified_at' => NULL,
    ]);

    $this->actingAs($user, 'api')
      ->get($this->verificationResendRoute());

    Notification::assertSentTo($user, VerifyEmail::class);
  }

  /**
   * Return a valid verification verify route.
   *
   * @param \App\Domains\Users\Models\User $user
   *
   * @return string
   */
  private function validVerificationVerifyRoute(User $user): string
  {
    return URL::signedRoute($this->verificationVerifyRouteName, [
      'id'   => $user->id,
      'hash' => sha1($user->getEmailForVerification()),
    ]);
  }

  /**
   * Return a invalid verification verify route.
   *
   * @param \App\Domains\Users\Models\User $user
   *
   * @return string
   */
  private function invalidVerificationVerifyRoute(User $user): string
  {
    return route($this->verificationVerifyRouteName, [
      'id'   => $user->id,
      'hash' => 'invalid-hash',
    ]);
  }

  /**
   * Return verification resend route.
   *
   * @return string
   */
  private function verificationResendRoute(): string
  {
    return route($this->verificationResendRouteName);
  }
}
