<?php

namespace App\Units\Customer\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Support\Http\Controllers\Controller;
use App\Domains\Customers\Resources\CustomerResource;
use App\Units\Customer\Http\Requests\CreateCustomerContactRequest;
use App\Units\Customer\Http\Requests\UpdateCustomerContactRequest;
use App\Domains\Customers\Contracts\Repositories\CustomerRepository;
use App\Domains\Customers\Contracts\Repositories\CustomerContactRepository;

/**
 * Class CustomerContactController
 *
 * @package App\Units\Customer\Http\Controllers
 */
class CustomerContactController extends Controller
{
  /**
   * @var \App\Domains\Customers\Contracts\Repositories\CustomerContactRepository
   */
  private CustomerContactRepository $customerContactRepository;

  /**
   * CustomerContactController constructor.
   *
   * @param \App\Domains\Customers\Contracts\Repositories\CustomerContactRepository $customerContactRepository
   */
  public function __construct(CustomerContactRepository $customerContactRepository)
  {
    $this->customerContactRepository = $customerContactRepository;
  }

  /**
   * Create a new contact from specif customer.
   *
   * @param \App\Units\Customer\Http\Requests\CreateCustomerContactRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function store(CreateCustomerContactRequest $request): JsonResponse
  {
    $customerContact = $this->customerContactRepository->create($request->all());

    return response()->json([
      'data' => $customerContact,
    ], Response::HTTP_CREATED);
  }

  /**
   * Update specific contact from specific customer.
   *
   * @param \App\Units\Customer\Http\Requests\UpdateCustomerContactRequest $request
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function update(UpdateCustomerContactRequest $request): JsonResponse
  {

    $customerContact = $this->customerContactRepository->findWhere([
      'id'          => $request->route('customerContactId'),
      'customer_id' => $request->route('customerId'),
    ])->firstOrFail();

    $this->customerContactRepository->update($customerContact, $request->all());

    return response()->json([
      'data' => $customerContact,
    ], Response::HTTP_OK);
  }

  /**
   * Delete specific contact from specific customer.
   *
   * @param string $customerId
   * @param string $contactId
   *
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception|\Illuminate\Contracts\Container\BindingResolutionException
   */
  public function destroy(string $customerId, string $contactId): JsonResponse
  {
    $customerContact = $this->customerContactRepository->findWhere([
      'id'          => $contactId,
      'customer_id' => $customerId,
    ])->firstOrFail();

    $this->customerContactRepository->delete($customerContact);

    return response()->json([
      'data' => $customerContact,
    ], Response::HTTP_NO_CONTENT);
  }
}
