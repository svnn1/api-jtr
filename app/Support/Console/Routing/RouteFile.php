<?php

namespace App\Support\Console\Routing;

use Illuminate\Contracts\Console\Kernel;

/**
 * Class RouteFile
 *
 * @package App\Support\Console\Routing
 */
abstract class RouteFile
{
  /**
   * @var \Illuminate\Contracts\Console\Kernel
   */
  protected Kernel $artisan;

  /**
   * @var \Illuminate\Contracts\Console\Kernel
   */
  protected Kernel $router;

  /**
   * RouteFile constructor.
   */
  public function __construct()
  {
    $this->artisan = app(Kernel::class);

    $this->router = $this->artisan;
  }

  /**
   * Register console routes.
   *
   * @return void
   */
  public function register(): void
  {
    $this->routes();
  }

  /**
   * Declare console routes.
   *
   * @return void
   */
  abstract public function routes(): void;
}
