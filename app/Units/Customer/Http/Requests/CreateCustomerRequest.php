<?php

namespace App\Units\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateCustomerRequest
 *
 * @package App\Units\Customer\Http\Requests
 */
class CreateCustomerRequest extends FormRequest
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
      "document_number" => "required|numeric|cpfcnpj|unique:customers",
      "name"            => "required|string",
      "email"           => "required|string|email|max:255|unique:customers",
      "website"         => "nullable|url",
    ];
  }
}
