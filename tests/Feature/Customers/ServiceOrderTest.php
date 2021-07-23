<?php

namespace Tests\Feature\Customers;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domains\Customers\Models\Customer;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use App\Domains\Customers\Models\ServiceOrder;

/**
 * Class ServiceOrderTest
 *
 * @package Tests\Feature\Customers
 */
class ServiceOrderTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  public function testCanCreateServiceOrder(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->post("/customers/{$customer->id}/service-orders", $data = [
      'type_service' => $this->faker->name,
      'status'       => array_rand(array_flip(['canceled', 'pending', 'completed'])),
      'priority'     => array_rand(array_flip(['low', 'medium', 'high'])),
    ])->assertStatus(Response::HTTP_CREATED);

    $this->assertDatabaseHas('service_orders', [
      'customer_id'  => $customer->id,
      'type_service' => $data['type_service'],
      'status'       => $data['status'],
      'priority'     => $data['priority'],
    ]);
  }

  public function testCannotCreateServiceOrderWithoutTypeService(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->post("/customers/{$customer->id}/service-orders", $data = [
      'type_service' => NULL,
      'status'       => array_rand(array_flip(['canceled', 'pending', 'completed'])),
      'priority'     => array_rand(array_flip(['low', 'medium', 'high'])),
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCanUpdateServiceOrder(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $serviceOrder = factory(ServiceOrder::class)->create([
      'customer_id' => $customer->id,
    ]);

    $this->put("/customers/{$customer->id}/service-orders/{$serviceOrder->id}", $data = [
      'type_service' => $this->faker->name,
      'status'       => array_rand(array_flip(['canceled', 'pending', 'completed'])),
      'priority'     => array_rand(array_flip(['low', 'medium', 'high'])),
    ])->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseHas('service_orders', [
      'customer_id'  => $customer->id,
      'type_service' => $data['type_service'],
      'status'       => $data['status'],
      'priority'     => $data['priority'],
    ]);
  }

  public function testCanUpdateServiceOrderWithoutTypeService(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $serviceOrder = factory(ServiceOrder::class)->create([
      'customer_id' => $customer->id,
    ]);

    $this->put("/customers/{$customer->id}/service-orders/{$serviceOrder->id}", $data = [
      'status'   => array_rand(array_flip(['canceled', 'pending', 'completed'])),
      'priority' => array_rand(array_flip(['low', 'medium', 'high'])),
    ])->assertStatus(Response::HTTP_OK);
  }

  public function testCanUpdateServiceOrderWithOnlyTypeService(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $serviceOrder = factory(ServiceOrder::class)->create([
      'customer_id' => $customer->id,
    ]);

    $this->patch("/customers/{$customer->id}/service-orders/{$serviceOrder->id}", $data = [
      'type_service' => $this->faker->name,
    ])->assertStatus(Response::HTTP_OK);
  }

  public function testCanDeleteServiceOrder(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $serviceOrder = factory(ServiceOrder::class)->create([
      'customer_id' => $customer->id,
    ]);

    $this->delete("/customers/{$customer->id}/service-orders/{$serviceOrder->id}")->assertStatus(Response::HTTP_NO_CONTENT);
  }
}
