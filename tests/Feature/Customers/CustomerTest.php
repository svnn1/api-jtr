<?php

namespace Tests\Feature\Customers;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domains\Customers\Models\Customer;
use App\Support\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Class CustomerTest
 *
 * @package Tests\Feature\Customers
 */
class CustomerTest extends TestCase
{
  use DatabaseMigrations, WithFaker;

  private int $documentNumber = 59572918036;

  private int $invalidDocumentNumber = 4564564;

  public function testCanCreateCustomer(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/customers', $data = [
      'document_number' => $this->documentNumber,
      'email'           => $this->faker->safeEmail,
      'name'            => $this->faker->name,
      'website'         => $this->faker->url,
    ])->assertStatus(Response::HTTP_CREATED);

    $this->assertDatabaseHas('customers', [
      'document_number' => $data['document_number'],
      'name'            => $data['name'],
      'email'           => $data['email'],
      'website'         => $data['website'],
    ]);
  }

  public function testCannotCreateWithoutDocumentNumber(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/customers', [
      'document_number' => NULL,
      'email'           => $this->faker->safeEmail,
      'name'            => $this->faker->name,
      'website'         => $this->faker->url,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCannotCreateWithoutName(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/customers', $data = [
      'document_number' => $this->documentNumber,
      'email'           => $this->faker->safeEmail,
      'name'            => NULL,
      'website'         => $this->faker->url,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCannotCreateWithoutEmail(): void
  {
    $this->runDatabaseMigrations();

    $this->post('/customers', $data = [
      'document_number' => $this->documentNumber,
      'email'           => NULL,
      'name'            => $this->faker->name,
      'website'         => $this->faker->url,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCanUpdateCustomer(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->put("/customers/{$customer->id}", $data = [
      'document_number' => $this->documentNumber,
      'email'           => $this->faker->safeEmail,
      'name'            => $this->faker->name,
      'website'         => $this->faker->url,
    ])->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseHas('customers', [
      'document_number' => $data['document_number'],
      'name'            => $data['name'],
      'email'           => $data['email'],
      'website'         => $data['website'],
    ]);
  }

  public function testCanUpdateOnlyOneFieldCustomer(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->patch("/customers/{$customer->id}", $data = [
      'document_number' => $this->documentNumber,
    ])->assertStatus(Response::HTTP_OK);

    $this->assertDatabaseHas('customers', [
      'document_number' => $data['document_number'],
    ]);
  }

  public function testCannotUpdateWithInvalidDocumentNumber(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->put("/customers/{$customer->id}", $data = [
      'document_number' => $this->invalidDocumentNumber,
      'email'           => $this->faker->safeEmail,
      'name'            => $this->faker->name,
      'website'         => $this->faker->url,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCannotUpdateWithInvalidEmail(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->put("/customers/{$customer->id}", $data = [
      'document_number' => $this->documentNumber,
      'email'           => $this->faker->streetName,
      'name'            => $this->faker->name,
      'website'         => $this->faker->url,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
  }

  public function testCanDeleteCustomer(): void
  {
    $this->runDatabaseMigrations();

    $customer = factory(Customer::class)->create();

    $this->delete("/customers/{$customer->id}")->assertStatus(Response::HTTP_NO_CONTENT);
  }
}
