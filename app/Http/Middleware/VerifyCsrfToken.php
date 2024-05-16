<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/orders/*/pay',
        '/me/cards',
        '/checkout',
        '/meetings/*/waiting-room',
        '/meetings/*/join',
        '/orders/*/checkout',
        '/agent/meetings/*/waiting-room',
        '/agent/meetings/*/join',
        '/webhooks/stripe',
        '/webhooks/zoho',
    ];
}
