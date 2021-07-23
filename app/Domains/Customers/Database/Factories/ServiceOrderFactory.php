<?php

namespace App\Domains\Customers\Database\Factories;

use App\Support\Domain\ModelFactory;
use App\Domains\Customers\Models\ServiceOrder;

/**
 * Class ServiceOrderFactory
 *
 * @package App\Domains\Customers\Database\Factories
 */
class ServiceOrderFactory extends ModelFactory
{
  /**
   * @var string
   */
  protected string $model = ServiceOrder::class;

  /**
   * @return array
   */
  public function fields(): array
  {
    return [
      'type_service' => $this->faker->word,
      'status'       => array_rand(array_flip(['canceled', 'pending', 'completed'])),
      'priority'     => array_rand(array_flip(['low', 'medium', 'high'])),
    ];
  }
}
