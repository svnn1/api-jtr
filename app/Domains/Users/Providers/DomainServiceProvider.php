<?php

namespace App\Domains\Users\Providers;

use App\Support\Domain\ServiceProvider;
use App\Domains\Users\Database\Seeders\UserSeeder;
use App\Domains\Users\Repositories as Repositories;
use App\Domains\Users\Database\Factories\UserFactory;
use App\Domains\Users\Contracts\Repositories as Contracts;
use App\Domains\Users\Database\Migrations\CreateUsersTable;
use App\Domains\Users\Database\Migrations\CreatePasswordResetsTable;

/**
 * Class DomainServiceProvider
 *
 * @package App\Domains\Users\Providers
 */
class DomainServiceProvider extends ServiceProvider
{
  /**
   * Domains alias for translations and other keys.
   *
   * @var string
   */
  protected string $alias = 'domain::users';

  /**
   * List of domain providers to register.
   *
   * @var array
   */
  protected array $subProviders = [
    EventServiceProvider::class,
  ];

  public array $bindings = [
    Contracts\UserRepository::class => Repositories\UserRepository::class,
  ];

  /**
   * List of migrations provided by domain.
   *
   * @var array
   */
  protected array $migrations = [
    CreatePasswordResetsTable::class,
    CreateUsersTable::class,
  ];

  /**
   * List of seeders provided by domain.
   *
   * @var array
   */
  protected array $seeders = [
    UserSeeder::class,
  ];

  /**
   * List of model factories to load.
   *
   * @var array
   */
  protected array $factories = [
    UserFactory::class,
  ];
}
