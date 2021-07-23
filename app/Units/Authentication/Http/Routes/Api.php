<?php

namespace App\Units\Authentication\Http\Routes;

use App\Support\Http\Routing\RouteFile;

/**
 * Class Api
 *
 * @package App\Units\Authentication\Http\Routes
 */
class Api extends RouteFile
{
  /**
   * Define routes.
   *
   * @return void
   */
  public function routes(): void
  {
    $this->registerLoginRoutes();
    $this->registerSignUpRoutes();
    $this->registerLogoutRoutes();
    $this->registerPasswordRoutes();
    $this->registerEmailVerificationRoutes();
  }

  protected function registerLoginRoutes(): void
  {
    $this->router->post('/login', 'LoginController@login')->name('login');
  }

  protected function registerSignUpRoutes(): void
  {
    $this->router->post('register', 'RegisterController@register')->name('register');
  }

  protected function registerLogoutRoutes(): void
  {
    $this->router->post('logout', 'LogoutController@logout')->name('logout')->middleware('auth:api');
  }

  protected function registerPasswordRoutes(): void
  {
    $this->router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->router->post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
  }

  protected function registerEmailVerificationRoutes(): void
  {
    $this->router->get('email/resend', 'VerificationController@resend')->name('verification.resend')->middleware('auth:api');
    $this->router->get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify')->middleware('auth:api');
  }
}
