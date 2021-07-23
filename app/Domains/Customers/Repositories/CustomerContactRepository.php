<?php

namespace App\Domains\Customers\Repositories;

use App\Support\Repositories\BaseRepository;
use App\Domains\Customers\Models\CustomerContact;
use App\Domains\Customers\Contracts\Repositories as Contracts;

/**
 * Class CustomerContactRepository
 *
 * @package App\Domains\Customers\Repositories
 */
class CustomerContactRepository extends BaseRepository implements Contracts\CustomerContactRepository
{
  /**
   * Model class for repository.
   *
   * @var string
   */
  protected string $model = CustomerContact::class;
}
