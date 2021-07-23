<?php

namespace App\Units\Core\Providers;

use App\Support\Unit\ServiceProvider;

/**
 * Class UnitServiceProvider
 *
 * @package App\Units\Core\Providers
 */
class UnitServiceProvider extends ServiceProvider
{
  /**
   * Unit Alias for Translations and Views.
   *
   * @var string
   */
  protected string $alias = 'unit::core';

  /**
   * List of Unit Service Providers to Register.
   *
   * @var array
   */
  protected array $providers = [
    BroadcastServiceProvider::class,
  ];
}
