<?php

namespace App\Units\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateServiceOrderRequest
 *
 * @package App\Units\Customer\Http\Requests
 */
class UpdateServiceOrderRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
  {
    return TRUE;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules(): array
  {
    return [
      "type_service"        => "nullable|string",
      "status"              => "nullable|in:canceled,pending,completed",
      "priority"            => "nullable|in:low,medium,high",
      'reported_problem'    => "nullable|string|min:10",
      'found_problem'       => "nullable|string|min:10",
      'service_description' => "nullable|string|min:10",
    ];
  }
}
