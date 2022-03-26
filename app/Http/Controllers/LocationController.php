<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function city()
    {
        $response = Http::get('https://psgc.vercel.app/api/city');

        return response()->json($response);
    }

    public function brgy(Request $request)
    {
        # code...
    }
}
