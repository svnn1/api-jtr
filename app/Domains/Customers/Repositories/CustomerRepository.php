<?php

namespace App\Domains\Customers\Repositories;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Customers\Models\Customer;
use App\Support\Repositories\BaseRepository;
use App\Domains\Customers\Contracts\Repositories as Contracts;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CustomerRepository
 *
 * @package App\Domains\Customers\Repositories
 */
class CustomerRepository extends BaseRepository implements Contracts\CustomerRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = Customer::class;

  /**
   * Set relationships for this repository.
   * 
   * @var array
   */
  private array $relationships = [
    'contacts', 'locations', 'orders'
  ];

  /**
   * Get all customer with relationships.
   * 
   * @param  array $columns
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getCustomerWithRelationships(array $columns = ['*']): Collection
  {
    return $this->queryBuilder()->allowedIncludes($this->relationships)->get($columns);
  }

  /**
   * Find custumer with relationships.
   * 
   * @param  string $customerId
   * @param  array  $columns
   *
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function findCustomerWithRelationships(string $customerId, array $columns = ['*']): Model
  {
    return $this->queryBuilder()->allowedIncludes($this->relationships)->find($customerId, $columns);
  }

  /**
   * Return query builder.
   * 
   * @return \Spatie\QueryBuilder\QueryBuilder;
   */
  public function queryBuilder(): QueryBuilder
  {
    return QueryBuilder::for($this->model);
  }
}
