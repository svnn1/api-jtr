<?php

namespace App\Domains\Customers\Database\Migrations;

use App\Support\Domain\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateServiceOrdersTable
 *
 * @package App\Domains\Customers\Database\Migrations
 */
class CreateServiceOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    $this->schema->create('service_orders', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('customer_id');
      //$table->uuid('technician'); Depois vai ser utilizado para adicionar um técnico existente.
      $table->unsignedBigInteger('order_number')->default(0);
      $table->string('type_service');
      $table->enum('status', ['canceled', 'pending', 'completed'])->default('pending');
      $table->enum('priority', ['low', 'medium', 'high'])->default('low');
      $table->text('reported_problem')->nullable();
      $table->text('found_problem')->nullable();
      $table->longText('service_description')->nullable();
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
    $this->schema->dropIfExists('service_orders');
  }
}
