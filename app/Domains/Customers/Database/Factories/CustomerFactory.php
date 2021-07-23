<?php

namespace App\Domains\Customers\Database\Factories;

use App\Domains\Customers\Models\Customer;
use App\Support\Domain\ModelFactory;

/**
 * Class CustomerFactory
 *
 * @package App\Domains\Customers\Database\Factories
 */
class CustomerFactory extends ModelFactory
{
  /**
   * @var string
   */
  protected string $model = Customer::class;

  /**
   * @return array
   */
  public function fields(): array
  {
    return [
      'document_number' => $this->faker->unique()->creditCardNumber,
      'email'           => $this->faker->unique()->email,
      'name'            => $this->faker->name,
      'website'         => $this->faker->url,
    ];
  }
}
