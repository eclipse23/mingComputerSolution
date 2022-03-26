<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesclaimerController extends Controller
{
    public function index()
    {
        return view('desclaimer');
    }
}
