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
        'admin/students/ajax/create',
        'admin/students/ajax/update',
        'admin/persons/ajax/create',
        'admin/persons/ajax/update',
        'admin/institutions/ajax/create',
        'admin/institutions/ajax/update'
    ];
}
