<?php

namespace App\Domains\Customers\Models;

use App\Support\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Customer
 *
 * @package App\Domains\Customers\Models
 */
class Customer extends Model
{
  use GenerateUuid;

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = FALSE;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'customers';

  /**
   * The "type" of the primary key ID.
   *
   * @var string
   */
  protected $keyType = 'string';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'document_number', 'email', 'name', 'website',
  ];

  /**
   * Return all contacts.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function contacts(): HasMany
  {
    return $this->hasMany(CustomerContact::class, 'customer_id', 'id');
  }

  /**
   * Return all locations.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function locations(): HasMany
  {
    return $this->hasMany(CustomerLocation::class, 'customer_id', 'id');
  }

  /**
   * Return all locations.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function orders(): HasMany
  {
    return $this->hasMany(ServiceOrder::class, 'customer_id', 'id');
  }
}
