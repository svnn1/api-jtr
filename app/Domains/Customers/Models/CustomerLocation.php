<?php

namespace App\Domains\Customers\Models;

use App\Support\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CustomerLocation
 *
 * @package App\Domains\Customers\Models
 */
class CustomerLocation extends Model
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
  protected $table = 'customer_locations';

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
    'customer_id', 'address', 'district', 'zip', 'country',
  ];

  public function customer(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }
}
