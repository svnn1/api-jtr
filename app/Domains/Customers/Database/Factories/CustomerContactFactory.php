<?php

namespace App\Domains\Customers\Database\Factories;

use App\Support\Domain\ModelFactory;
use App\Domains\Customers\Models\CustomerContact;

/**
 * Class CustomerContactFactory
 *
 * @package App\Domains\Customers\Database\Factories
 */
class CustomerContactFactory extends ModelFactory
{
  /**
   * @var string
   */
  protected string $model = CustomerContact::class;

  /**
   * @return array
   */
  public function fields(): array
  {
    return [
      'name'      => $this->faker->name,
      'telephone' => $this->faker->phoneNumber,
      'cellphone' => $this->faker->phoneNumber,
    ];
  }
}
