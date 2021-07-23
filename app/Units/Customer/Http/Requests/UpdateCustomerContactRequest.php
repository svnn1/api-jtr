<?php

namespace App\Units\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateCustomerContactRequest
 *
 * @package App\Units\Customer\Http\Requests
 */
class UpdateCustomerContactRequest extends FormRequest
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
      "customer_id" => "required|exists:customers,id",
      "name"        => "string|min:3",
      "telephone"   => "integer|phone:BR,fixed_line",
      "cellphone"   => "integer|phone:BR,mobile",
    ];
  }
}
