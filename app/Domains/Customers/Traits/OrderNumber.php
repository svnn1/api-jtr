<?php


namespace App\Domains\Customers\Traits;

/**
 * Trait OrderNumber
 *
 * @package App\Domains\Customers\Traits
 */
trait OrderNumber
{
  /**
   * Generate uuid.
   *
   * @return void
   */
  protected static function bootOrderNumber(): void
  {
    static::creating(function ($model) {
      $model->order_number = (integer) $model->count() + 1;
    });
  }
}
