<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {
        $product = Product::where('id', $request->input('id'))->first();
        $collection = 'product-image-'.$request->input('order').'';
        createLog($product, ['collection' => $collection], 'Update Product Image');
        return $product->addMedia($request->file('image'))->toMediaCollection($collection);
    }

    public function destroy(Request $request, Product $product)
    {
        $collection = 'product-image-'.$request->input('order').'';
        createLog($product, ['collection' => $collection], 'Delete Product Image');
        return $product->clearMediaCollection($collection);
    }
}
