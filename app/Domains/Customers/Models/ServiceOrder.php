<?php

namespace App\Domains\Customers\Models;

use App\Support\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Customers\Traits\OrderNumber;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ServiceOrder
 *
 * @package App\Domains\Customers\Models
 */
class ServiceOrder extends Model
{
  use GenerateUuid, OrderNumber;

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
  protected $table = 'service_orders';

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
    'customer_id', 'type_service', 'status', 'priority', 'reported_problem', 'found_problem', 'service_description',
  ];

  public function customer(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }
}
