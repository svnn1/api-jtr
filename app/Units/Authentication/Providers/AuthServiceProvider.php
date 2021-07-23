<?php

namespace App\Units\Authentication\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 *
 * @package App\Units\Authentication\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();
  }
}
