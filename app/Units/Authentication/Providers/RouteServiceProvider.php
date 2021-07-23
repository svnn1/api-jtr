<?php

namespace App\Units\Authentication\Providers;

use App\Units\Authentication\Http\Routes\Api;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider
 *
 * @package App\Units\Authentication\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
  protected $namespace = 'App\Units\Authentication\Http\Controllers';

  /**
   * Define the routes for the application.
   *
   * @return void
   */
  public function map(): void
  {
    $this->mapApiRoutes();
  }

  /**
   * Define routes for this unit.
   *
   * @return void
   */
  protected function mapApiRoutes(): void
  {
    (new Api([
      'middleware' => 'api',
      'namespace'  => $this->namespace,
    ]))->register();
  }
}
