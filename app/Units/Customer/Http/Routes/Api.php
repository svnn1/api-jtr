<?php

namespace App\Units\Customer\Http\Routes;

use App\Support\Http\Routing\RouteFile;

/**
 * Class Api
 *
 * @package App\Units\Customer\Http\Routes
 */
class Api extends RouteFile
{
  /**
   * Define routes.
   *
   * @return void
   */
  public function routes(): void
  {
    $this->registerCustomerRoutes();
    $this->registerCustomerContactsRoutes();
    $this->registerServiceOrderRoutes();
  }

  private function registerCustomerRoutes(): void
  {
    $this->router->group(['as' => 'contact.'], function () {
      $this->router->get('customers', 'CustomerController@index')->name("index");
      $this->router->post('customers', 'CustomerController@store')->name("store");
      $this->router->get('customers/{customerId}', 'CustomerController@show')->name("show");
      $this->router->match(['patch', 'put'], 'customers/{customerId}', 'CustomerController@update')->name("update");
      $this->router->delete('customers/{customerId}', 'CustomerController@destroy')->name("destroy");
    });
  }

  private function registerCustomerContactsRoutes(): void
  {
    $this->router->group(['as' => 'customer.contact.', 'prefix' => 'customers/{customerId}/'], function () {
      $this->router->post('contacts', 'CustomerContactController@store')->name('store');
      $this->router->match(['patch', 'put'], 'contacts/{customerContactId}', 'CustomerContactController@update')->name('update');
      $this->router->delete('contacts/{customerContactId}', 'CustomerContactController@destroy')->name('destroy');
    });
  }

  private function registerServiceOrderRoutes(): void
  {
    $this->router->group(['as' => 'customer.service-order.', 'prefix' => 'customers/{customerId}/'], function () {
      $this->router->post('service-orders', 'ServiceOrderController@store')->name('store');
      $this->router->get('service-orders/{serviceOrderId}', 'ServiceOrderController@show')->name('show');
      $this->router->match(['patch', 'put'], 'service-orders/{serviceOrderId}', 'ServiceOrderController@update')->name('update');
      $this->router->delete('service-orders/{serviceOrderId}', 'ServiceOrderController@destroy')->name('destroy');
    });
  }
}
