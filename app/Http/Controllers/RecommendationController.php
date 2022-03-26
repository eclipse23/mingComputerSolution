<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\Product as ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Tigo\Recommendation\Recommend;
use App\Http\Resources\Product\ProductCollection;
use App\Models\Recommendation;

class RecommendationController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::where('id', $request->input('product_id'))->first();
        
        return storeRecommendation($product);
    }

    public function heroData()
    {
        $table = Recommendation::get();
        $client = new Recommend();
        $productIds = $client->ranking($table,auth()->user()->id);
        $productIds = array_keys($productIds);
        $index = 0;
        foreach($productIds as $id) {
            $product = new ProductResource(Product::where('id', $id)->first());
            $productIds[$index] = $product;
            $index++;
        }

        return response()->json($productIds);
    }
}
