<?php

namespace App\Units\Core\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * Class EncryptCookies
 *
 * @package App\Units\Core\Http\Middleware
 */
class EncryptCookies extends Middleware
{
  /**
   * The names of the cookies that should not be encrypted.
   *
   * @var array
   */
  protected $except = [];
}
