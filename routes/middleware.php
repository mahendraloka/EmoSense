<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

return [

    'auth' => Authenticate::class,
    'guest' => RedirectIfAuthenticated::class,
];
