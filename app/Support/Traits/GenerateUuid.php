<?php

namespace App\Support\Traits;

use Illuminate\Support\Str;

/**
 * Trait GenerateUuid
 *
 * @package App\Support\Traits
 */
trait GenerateUuid
{
  /**
   * Generate uuid.
   *
   * @return void
   */
  protected static function bootGenerateUuid(): void
  {
    static::creating(function ($model) {
      $model->id = (string) Str::uuid();
    });
  }
}
