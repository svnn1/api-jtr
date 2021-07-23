<?php

namespace App\Units\Authentication\Providers;

use App\Support\Unit\ServiceProvider;

/**
 * Class UnitServiceProvider
 *
 * @package App\Units\Authentication\Providers
 */
class UnitServiceProvider extends ServiceProvider
{
  /**
   * Unit Alias for Translations and Views.
   *
   * @var string
   */
  protected string $alias = 'unit::authentication';

  /**
   * List of Unit Service Providers to Register.
   *
   * @var array
   */
  protected array $providers = [
    AuthServiceProvider::class,
    RouteServiceProvider::class,
  ];
}
