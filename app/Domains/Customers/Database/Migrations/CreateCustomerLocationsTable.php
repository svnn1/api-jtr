<?php

namespace App\Domains\Customers\Database\Migrations;

use App\Support\Domain\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateCustomerLocations
 *
 * @package App\Domains\Customers\Database\Migrations
 */
class CreateCustomerLocationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    $this->schema->create('customer_locations', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('customer_id');
      $table->string('address');
      $table->string('district');
      $table->string('zip');
      $table->string('country');
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
    $this->schema->dropIfExists('customer_locations');
  }
}
