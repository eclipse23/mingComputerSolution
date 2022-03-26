<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InvenoryController extends Controller
{
    public function getProducts()
    {
        return response()->json(Product::orderBy('name')->get());
    }

    public function print()
    {
        $data = Product::orderBy('name')->get();

        return view('inventory-report', ['data' => $data]);
    }
}
