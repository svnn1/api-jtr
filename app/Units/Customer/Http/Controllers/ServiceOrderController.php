<?php

namespace App\Units\Customer\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Support\Http\Controllers\Controller;
use App\Units\Customer\Http\Requests\CreateServiceOrderRequest;
use App\Units\Customer\Http\Requests\UpdateServiceOrderRequest;
use App\Domains\Customers\Contracts\Repositories\ServiceOrderRepository;

/**
 * Class ServiceOrderController
 *
 * @package App\Units\Customer\Http\Controllers
 */
class ServiceOrderController extends Controller
{
  /**
   * @var \App\Domains\Customers\Contracts\Repositories\ServiceOrderRepository
   */
  private ServiceOrderRepository $serviceOrderRepository;

  /**
   * ServiceOrderController constructor.
   *
   * @param \App\Domains\Customers\Contracts\Repositories\ServiceOrderRepository $serviceOrderRepository
   */
  public function __construct(ServiceOrderRepository $serviceOrderRepository)
  {
    $this->serviceOrderRepository = $serviceOrderRepository;
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function index(): JsonResponse
  {
    $newQuery = $this->serviceOrderRepository->newQuery();

    $serviceOrders = $newQuery->get();

    return response()->json([
      'data' => $serviceOrders,
    ], Response::HTTP_OK);
  }

  /**
   * @param \App\Units\Customer\Http\Requests\CreateServiceOrderRequest $request
   *
   * @param string                                                      $customerId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function store(CreateServiceOrderRequest $request, string $customerId): JsonResponse
  {
    $request->merge(['customer_id' => $customerId]);

    $serviceOrder = $this->serviceOrderRepository->create($request->all());

    return response()->json([
      'data' => $serviceOrder,
    ], Response::HTTP_CREATED);
  }

  /**
   * @param string $customerId
   * @param string $serviceOrderId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function show(string $customerId, string $serviceOrderId): JsonResponse
  {
    $serviceOrder = $this->serviceOrderRepository->findWhere([
      'id'          => $serviceOrderId,
      'customer_id' => $customerId,
    ])->firstOrFail();

    return response()->json([
      'data' => $serviceOrder,
    ], Response::HTTP_OK);
  }

  /**
   * @param \App\Units\Customer\Http\Requests\UpdateServiceOrderRequest $request
   * @param string                                                      $customerId
   * @param string                                                      $serviceOrderId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function update(UpdateServiceOrderRequest $request, string $customerId, string $serviceOrderId): JsonResponse
  {
    $serviceOrder = $this->serviceOrderRepository->findWhere([
      'id'          => $serviceOrderId,
      'customer_id' => $customerId,
    ])->firstOrFail();

    $this->serviceOrderRepository->update($serviceOrder, $request->all());

    return response()->json([
      'data' => $serviceOrder,
    ], Response::HTTP_OK);
  }

  /**
   * @param string $customerId
   * @param string $serviceOrderId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception|\Illuminate\Contracts\Container\BindingResolutionException
   */
  public function destroy(string $customerId, string $serviceOrderId): JsonResponse
  {
    $serviceOrder = $this->serviceOrderRepository->findWhere([
      'id'          => $serviceOrderId,
      'customer_id' => $customerId,
    ])->firstOrFail();

    $this->serviceOrderRepository->delete($serviceOrder);

    return response()->json([], Response::HTTP_NO_CONTENT);
  }
}
