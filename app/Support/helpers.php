<?php

use App\Support\Flash\Flash;

if (!function_exists('flat')) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}
