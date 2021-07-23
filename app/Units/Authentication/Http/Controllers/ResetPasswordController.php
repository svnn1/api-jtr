<?php

namespace App\Units\Authentication\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Support\Http\Controllers\Controller;
use App\Units\Authentication\Http\Requests\ResetPasswordRequest;

/**
 * Class ResetPasswordController
 *
 * @package App\Units\Authentication\Http\Controllers
 */
class ResetPasswordController extends Controller
{
  /**
   * ResetPasswordController constructor.
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Reset password.
   *
   * @param \App\Units\Authentication\Http\Requests\ResetPasswordRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function reset(ResetPasswordRequest $request)
  {
    $response = Password::broker()->reset(
      $request->only(
        'email', 'password', 'password_confirmation', 'token'
      ), function ($user) use ($request) {
      $user->password = bcrypt($request->get('password'));
      $user->setRememberToken(Str::random(60));
      $user->save();

      event(new PasswordReset($user));
    });

    return $response == Password::PASSWORD_RESET
      ? $this->sendResetResponse($request, $response)
      : $this->sendResetFailedResponse($request, $response);
  }

  /**
   * Get the response for a successful password reset.
   *
   * @param \Illuminate\Http\Request $request
   * @param string                   $response
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetResponse(Request $request, string $response)
  {
    return response()->json([
      'data' => [
        'status' => trans($response),
      ],
    ], Response::HTTP_OK);
  }

  /**
   * Get the response for a failed password reset.
   *
   * @param \Illuminate\Http\Request $request
   * @param string                   $response
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetFailedResponse(Request $request, string $response)
  {
    return response()->json([
      'error' => [
        'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
        'message' => trans($response),
      ],
    ], Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
