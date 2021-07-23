<?php

namespace App\Units\Customer\Providers;

use App\Support\Unit\ServiceProvider;

/**
 * Class UnitServiceProvider
 *
 * @package App\Units\Customer\Providers
 */
class UnitServiceProvider extends ServiceProvider
{
  /**
   * Unit Alias for Translations and Views.
   *
   * @var string
   */
  protected string $alias = 'unit::customer';

  /**
   * List of Unit Service Providers to Register.
   *
   * @var array
   */
  protected array $providers = [
    RouteServiceProvider::class,
  ];
}
