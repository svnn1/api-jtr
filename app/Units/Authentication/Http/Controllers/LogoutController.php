<?php

namespace App\Units\Authentication\Http\Controllers;

use Illuminate\Http\Response;
use App\Support\Http\Controllers\Controller;

/**
 * Class LogoutController
 *
 * @package App\Units\Authentication\Http\Controllers
 */
class LogoutController extends Controller
{
  /**
   * Log the user out of the application.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    auth('api')->logout();

    return response()->json([
      'data' => [
        'message' => 'You have successfully logged out.',
      ],
    ], Response::HTTP_OK);
  }
}
