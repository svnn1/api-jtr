<?php

namespace App\Domains\Customers\Database\Migrations;

use App\Support\Domain\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateCustomersTable
 *
 * @package App\Domains\Customers\Database\Migrations
 */
class CreateCustomersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    $this->schema->create('customers', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->bigInteger('document_number')->unique();
      $table->string('email')->unique();
      $table->string('name');
      $table->string('website')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    $this->schema->dropIfExists('customers');
  }
}
