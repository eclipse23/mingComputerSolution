<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginRedirectController extends Controller
{
    public function login()
    {
        if (!auth()->check()) {
            return redirect('/welcome');
        }

        if(auth()->user()->isCustomer()) {
            return redirect('/');
        } else {
            return redirect('/administrator/orders');
        }
    }
}
