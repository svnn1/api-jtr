<?php

namespace App\Units\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * Class BroadcastServiceProvider
 *
 * @package App\Units\Core\Providers
 */
class BroadcastServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot(): void
  {
    Broadcast::routes();
  }
}
