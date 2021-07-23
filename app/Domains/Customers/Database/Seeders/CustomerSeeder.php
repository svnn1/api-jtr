<?php

namespace App\Domains\Customers\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Customers\Models\Customer;
use App\Domains\Customers\Models\CustomerContact;
use App\Domains\Customers\Models\CustomerLocation;

/**
 * Class CustomerSeeder
 *
 * @package App\Domains\Customers\Database\Seeders
 */
class CustomerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(): void
  {
    factory(Customer::class)->times(5)->create()->each(function (Customer $customer) {
      $customerContacts = factory(CustomerContact::class)->times(5)->make();
      $customerLocations = factory(CustomerLocation::class)->times(5)->make();

      $customer->contacts()->saveMany($customerContacts);
      $customer->locations()->saveMany($customerLocations);
    });
  }
}
