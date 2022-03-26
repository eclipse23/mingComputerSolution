<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\Product as ProductResource;

class ProductViewController extends Controller
{
    public function products(Request $request)
    {

        $data = (object)[
            'type' => 'products',
            'title' => 'All Products',
            'search' => $request->filled('search') ? $request->input('search') : ''
        ];
        return view('frontend.products-grid', ['data' => $data]);
    }

    public function newArrivals()
    {
        $data = (object)[
            'type' => 'new-arrival',
            'title' => 'New Arrival',
            'search' => ''
        ];
        return view('frontend.products-grid', ['data' => $data]);
    }
    
    public function hotDeals()
    {
        $data = (object)[
            'type' => 'hot-deal',
            'title' => 'Hot Deal',
            'search' => ''
        ];
        return view('frontend.products-grid', ['data' => $data]);
    }

    public function list(Request $request)
    {
        $products = Product::query();

        if($request->input('type') == 'hot-deal') {
            $products = $products->where('hot_deal', '=', 1);
        }

        if($request->input('type') == 'new-arrival') {
            $products = $products->where('new_arrival', '=', 1);
        }

        if($request->filled('category')) {
            $products = $products->where('category_id', '=', $request->input('category'));
        }

        if($request->filled('search')) {
            $products = $products->where('name', 'LIKE', '%'.$request->input('search').'%')->orWhere('brand', 'LIKE', '%'.$request->input('search').'%');
        }

        $datas = $products->orderBy('name', 'asc')->paginate(12);
        
        return new ProductCollection($datas);
    }

    public function show(Product $product)
    {
        $data = new ProductResource($product);
        return view('frontend.product-detail', ['data' => $data]);
    }

    public function stock(Product $product)
    {
        return response()->json($product->stock-$product->reserved);
    }
}
