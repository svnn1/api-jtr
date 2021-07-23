<?php

namespace App\Units\Customer\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Support\Http\Controllers\Controller;
use App\Domains\Customers\Resources\CustomerResource;
use App\Units\Customer\Http\Requests\UpdateCustomerRequest;
use App\Units\Customer\Http\Requests\CreateCustomerRequest;
use App\Domains\Customers\Contracts\Repositories\CustomerRepository;

/**
 * Class CustomerController
 *
 * @package App\Units\Customer\Http\Controllers
 */
class CustomerController extends Controller
{
  /**
   * @var \App\Domains\Customers\Contracts\Repositories\CustomerRepository
   */
  private CustomerRepository $customerRepository;

  /**
   * CustomerController constructor.
   *
   * @param \App\Domains\Customers\Contracts\Repositories\CustomerRepository $customerRepository
   */
  public function __construct(CustomerRepository $customerRepository)
  {
    $this->customerRepository = $customerRepository;
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function index(): JsonResponse
  {
    $collection = $this->customerRepository->getCustomerWithRelationships();

    return response()->json([
      'data' => $collection,
    ], Response::HTTP_OK);
  }

  /**
   * Create a new customer.
   *
   * @param \App\Units\Customer\Http\Requests\CreateCustomerRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function store(CreateCustomerRequest $request): JsonResponse
  {
    $customer = $this->customerRepository->create($request->all());

    return response()->json([
      'data' => $customer,
    ], Response::HTTP_CREATED);
  }

  /**
   * @param string $customerId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function show(string $customerId): JsonResponse
  {
    $customer = $this->customerRepository->findCustomerWithRelationships($customerId);

    return response()->json([
      'data' => $customer,
    ], Response::HTTP_OK);
  }

  /**
   * @param \App\Units\Customer\Http\Requests\UpdateCustomerRequest $request
   * @param string                                                  $customerId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function update(UpdateCustomerRequest $request, string $customerId): JsonResponse
  {
    $customer = $this->customerRepository->find($customerId);

    $this->customerRepository->update($customer, $request->all());


    return response()->json([
      'data' => $customer,
    ], Response::HTTP_OK);
  }

  /**
   * @param string $customerId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception|\Illuminate\Contracts\Container\BindingResolutionException
   */
  public function destroy(string $customerId): JsonResponse
  {
    $customer = $this->customerRepository->find($customerId);

    $this->customerRepository->delete($customer);

    return response()->json([], Response::HTTP_NO_CONTENT);
  }
}
