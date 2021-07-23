<?php

namespace App\Units\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateCustomerRequest
 *
 * @package App\Units\Customer\Http\Requests
 */
class UpdateCustomerRequest extends FormRequest
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
      "document_number" => "cpfcnpj|numeric|unique:customers",
      "name"            => "string|min:3",
      "email"           => "string|email|min:3|unique:customers",
      "website"         => "nullable|url",
    ];
  }
}
