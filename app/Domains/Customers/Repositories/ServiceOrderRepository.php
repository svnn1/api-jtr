<?php

namespace App\Domains\Customers\Repositories;

use App\Support\Repositories\BaseRepository;
use App\Domains\Customers\Models\ServiceOrder;
use App\Domains\Customers\Contracts\Repositories as Contracts;

/**
 * Class ServiceOrderRepository
 *
 * @package App\Domains\Customers\Repositories
 */
class ServiceOrderRepository extends BaseRepository implements Contracts\ServiceOrderRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = ServiceOrder::class;
}
