<?php

namespace App\Units\Authentication\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use App\Support\Http\Controllers\Controller;
use App\Units\Authentication\Http\Requests\ForgotPasswordRequest;

/**
 * Class ForgotPasswordController
 *
 * @package App\Units\Authentication\Http\Controllers
 */
class ForgotPasswordController extends Controller
{
  /**
   * ForgotPasswordController constructor.
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Send reset link email.
   *
   * @param \App\Units\Authentication\Http\Requests\ForgotPasswordRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetLinkEmail(ForgotPasswordRequest $request)
  {
    $response = Password::broker()->sendResetLink(
      $request->only('email')
    );

    return $response == Password::RESET_LINK_SENT
      ? $this->sendResetLinkResponse($response)
      : $this->sendResetLinkFailedResponse($request, $response);
  }

  /**
   * Get the response for a successful password reset link.
   *
   * @param string $response
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetLinkResponse(string $response)
  {
    return response()->json([
      'data' => [
        'status' => trans($response),
      ],
    ], Response::HTTP_OK);
  }

  /**
   * Get the response for a failed password reset link.
   *
   * @param \Illuminate\Http\Request $request
   * @param string                   $response
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function sendResetLinkFailedResponse(Request $request, string $response)
  {
    return response()->json([
      'error' => [
        'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
        'message' => trans($response),
      ],
    ], Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
