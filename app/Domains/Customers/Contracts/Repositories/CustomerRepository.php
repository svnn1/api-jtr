<?php

namespace App\Domains\Customers\Contracts\Repositories;

use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Support\Contracts\Repository\BaseRepository;

/**
 * Interface CustomerRepository
 *
 * @package App\Domains\Customers\Contracts\Repositories
 */
interface CustomerRepository extends BaseRepository
{
  /**
   * Get all customer with relationships.
   * 
   * @param  array $columns
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getCustomerWithRelationships(array $columns = ['*']): Collection;

  /**
   * Find custumer with relationships.
   * 
   * @param  string $customerId
   * @param  array 	$columns
   *
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function findCustomerWithRelationships(string $customerId, array $columns = ['*']): Model;

  /**
   * Return query builder.
   * 
   * @return \Spatie\QueryBuilder\QueryBuilder;
   */
  public function queryBuilder(): QueryBuilder;
}
