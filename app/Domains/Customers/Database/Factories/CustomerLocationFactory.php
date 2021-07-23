<?php

namespace App\Domains\Customers\Database\Factories;

use App\Support\Domain\ModelFactory;
use App\Domains\Customers\Models\CustomerLocation;

/**
 * Class CustomerLocationFactory
 *
 * @package App\Domains\Customers\Database\Factories
 */
class CustomerLocationFactory extends ModelFactory
{
  /**
   * @var string
   */
  protected string $model = CustomerLocation::class;

  /**
   * @return array
   */
  public function fields(): array
  {
    return [
      'address'  => $this->faker->streetName,
      'district' => $this->faker->city,
      'zip'      => $this->faker->postcode,
      'country'  => $this->faker->country,
    ];
  }
}
