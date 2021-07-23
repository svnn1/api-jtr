<?php

namespace App\Domains\Customers\Database\Migrations;

use App\Support\Domain\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateCustomerContactsTable
 *
 * @package App\Domains\Customers\Database\Migrations
 */
class CreateCustomerContactsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    $this->schema->create('customer_contacts', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('customer_id');
      $table->string('name');
      $table->integer('telephone')->nullable();
      $table->bigInteger('cellphone')->nullable();
      $table->timestamps();

      $table->foreign('customer_id')->references('id')->on('customers')->onDelete('CASCADE');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    $this->schema->dropIfExists('customer_contacts');
  }
}
