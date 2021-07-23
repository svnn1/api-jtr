<?php

namespace App\Units\Authentication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResetPasswordRequest
 *
 * @package App\Units\Authentication\Http\Requests
 */
class ResetPasswordRequest extends FormRequest
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
      'token'    => 'required|string',
      'email'    => 'required|string|email',
      'password' => 'required|string|min:8|max:60|confirmed',
    ];
  }
}
