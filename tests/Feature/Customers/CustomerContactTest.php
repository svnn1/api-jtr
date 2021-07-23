<?php

namespace Tests\Feature\Customers;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domains\Customers\Models\Customer;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use App\Domains\Customers\Models\CustomerContact;

/**
 * Class CustomerContactTest
 *
 * @package Tests\Feature\Customers
 */
class CustomerContactTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  public function testCanCreateCustomerContact(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $response = $this->post("/customers/{$customer->id}/contacts", $data = [
      'customer_id' => $customer->id,
      'name'        => $this->faker->name,
      'telephone'   => 1124564935,
      'cellphone'   => 11945210885,
    ])->assertStatus(Response::HTTP_CREATED);

    $this->assertDatabaseHas('customer_contacts', [
      "name"      => $data['name'],
      "telephone" => $data['telephone'],
      "cellphone" => $data['cellphone'],
    ]);
  }

  public function testCannotCreateCustomerContactWithoutName(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->post("/customers/{$customer->id}/contacts", [
      'name'      => NULL,
      'telephone' => $this->faker->phoneNumber,
      'cellphone' => $this->faker->phoneNumber,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCannotCreateCustomerContactWithoutTelephone(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->post("/customers/{$customer->id}/contacts", [
      'name'      => $this->faker->name,
      'telephone' => NULL,
      'cellphone' => $this->faker->phoneNumber,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCannotCreateCustomerContactWithoutCellphone(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->post("/customers/{$customer->id}/contacts", [
      'name'      => $this->faker->name,
      'telephone' => $this->faker->phoneNumber,
      'cellphone' => NULL,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCanUpdateCustomerContact(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $customerContact = factory(CustomerContact::class)->create([
      'customer_id' => $customer->id,
    ]);

    $this->put("/customers/{$customer->id}/contacts/{$customerContact->id}", $data = [
      'customer_id' => $customer->id,
      'name'        => $this->faker->name,
      'telephone'   => 1122422188,
      'cellphone'   => 11975112771,
    ])->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseHas('customer_contacts', [
      'name'      => $data['name'],
      'telephone' => $data['telephone'],
      'cellphone' => $data['cellphone'],
    ]);
  }

  public function testCanUpdateOnlyOneFieldCustomerContact(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $customerContact = factory(CustomerContact::class)->create([
      'customer_id' => $customer->id,
    ]);

    $this->put("/customers/{$customer->id}/contacts/{$customerContact->id}", $data = [
      'customer_id' => $customer->id,
      'name'        => $this->faker->name,
    ])->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseHas('customer_contacts', [
      'name' => $data['name'],
    ]);
  }

  public function testCanDeleteCustomerContact(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $customerContact = factory(CustomerContact::class)->create([
      'customer_id' => $customer->id,
    ]);

    $this->delete("/customers/{$customer->id}/contacts/{$customerContact->id}")->assertStatus(Response::HTTP_NO_CONTENT);
  }
}
