<?php

namespace App\Domains\Users\Database\Factories;

use App\Domains\Users\Models\User;
use App\Support\Domain\ModelFactory;

/**
 * Class UserFactory
 *
 * @package App\Domains\Users\Database\Factories
 */
class UserFactory extends ModelFactory
{
  /**
   * @var string
   */
  protected string $model = User::class;

  /**
   * @return array
   */
  public function fields(): array
  {
    return [
      'name'           => $this->faker->name,
      'email'          => $this->faker->safeEmail,
      'password'       => bcrypt('secret'),
      'remember_token' => $this->faker->randomNumber(),
    ];
  }
}
