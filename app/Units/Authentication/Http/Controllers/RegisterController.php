<?php

namespace App\Units\Authentication\Http\Controllers;

use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Support\Http\Controllers\Controller;
use App\Units\Authentication\Http\Requests\RegisterRequest;
use App\Domains\Users\Contracts\Repositories\UserRepository;

/**
 * Class RegisterController
 *
 * @package App\Units\Authentication\Http\Controllers
 */
class RegisterController extends Controller
{
  /**
   * RegisterController constructor.
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Create a new user.
   *
   * @param \App\Units\Authentication\Http\Requests\RegisterRequest  $request
   * @param \App\Domains\Users\Contracts\Repositories\UserRepository $userRepository
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function register(RegisterRequest $request, UserRepository $userRepository)
  {
    $user = $userRepository->create([
      'name'     => $request->get('name'),
      'email'    => $request->get('email'),
      'password' => bcrypt($request->get('password')),
    ]);

    try {
      $token = auth('api')->fromUser($user);
    } catch (JWTException $exception) {
      return response()->json([
        'error' => [
          'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
          'message' => 'Error generating token.',
        ],
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    return response()->json([
      'data' => [
        'access_token' => $token,
        'token_type'   => 'Bearer',
        'expires_in'   => auth('api')->factory()->getTTL() * 60,
      ],
    ], Response::HTTP_CREATED);
  }
}
