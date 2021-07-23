<?php

namespace App\Domains\Customers\Providers;

use App\Support\Domain\ServiceProvider;
use App\Domains\Customers\Repositories as Repositories;
use App\Domains\Customers\Database\Seeders\CustomerSeeder;
use App\Domains\Customers\Database\Factories\CustomerFactory;
use App\Domains\Customers\Contracts\Repositories as Contracts;
use App\Domains\Customers\Database\Factories\ServiceOrderFactory;
use App\Domains\Customers\Database\Migrations\CreateCustomersTable;
use App\Domains\Customers\Database\Factories\CustomerContactFactory;
use App\Domains\Customers\Database\Factories\CustomerLocationFactory;
use App\Domains\Customers\Database\Migrations\CreateServiceOrdersTable;
use App\Domains\Customers\Database\Migrations\CreateCustomerContactsTable;
use App\Domains\Customers\Database\Migrations\CreateCustomerLocationsTable;

/**
 * Class DomainServiceProvider
 *
 * @package App\Domains\Customers\Providers
 */
class DomainServiceProvider extends ServiceProvider
{
  /**
   * Domains alias for translations and other keys.
   *
   * @var string
   */
  protected string $alias = 'domain::customers';

  /**
   * List of domain providers to register.
   *
   * @var array
   */
  protected array $subProviders = [];

  /**
   * Register a bindings.
   *
   * @var array
   */
  public array $bindings = [
    Contracts\CustomerRepository::class        => Repositories\CustomerRepository::class,
    Contracts\CustomerContactRepository::class => Repositories\CustomerContactRepository::class,
    Contracts\ServiceOrderRepository::class    => Repositories\ServiceOrderRepository::class,
  ];

  /**
   * List of migrations provided by domain.
   *
   * @var array
   */
  protected array $migrations = [
    CreateCustomersTable::class,
    CreateCustomerContactsTable::class,
    CreateCustomerLocationsTable::class,
    CreateServiceOrdersTable::class,
  ];

  /**
   * List of seeders provided by domain.
   *
   * @var array
   */
  protected array $seeders = [
    CustomerSeeder::class,
  ];

  /**
   * List of model factories to load.
   *
   * @var array
   */
  protected array $factories = [
    CustomerFactory::class,
    CustomerContactFactory::class,
    CustomerLocationFactory::class,
    ServiceOrderFactory::class,
  ];
}
