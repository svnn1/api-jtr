<?php

namespace App\Units\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateCustomerContactRequest
 *
 * @package App\Units\Customer\Http\Requests
 */
class CreateCustomerContactRequest extends FormRequest
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
      "name"        => "required|string",
      "telephone"   => "nullable|integer|phone:BR,fixed_line",
      "cellphone"   => "nullable|integer|phone:BR,mobile",
    ];
  }
}
