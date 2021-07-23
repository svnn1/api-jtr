<?php

namespace App\Units\Core\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * Class VerifyCsrfToken
 *
 * @package App\Units\Core\Http\Middleware
 */
class VerifyCsrfToken extends Middleware
{
  /**
   * Indicates whether the XSRF-TOKEN cookie should be set on the response.
   *
   * @var bool
   */
  protected $addHttpCookie = TRUE;

  /**
   * The URIs that should be excluded from CSRF verification.
   *
   * @var array
   */
  protected $except = [];
}
