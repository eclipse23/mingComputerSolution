<?php

namespace App;


class App
{

    public static function get()
    {
        return [
            'current_user' => auth()->check() ? auth()->user() : null,
            'is_customer' => auth()->check() ? auth()->user()->isCustomer() : false,
            'is_admin' => auth()->check() ? auth()->user()->isAdmin() : false,
            'logged_in' => auth()->check(),
        ];
    }
}