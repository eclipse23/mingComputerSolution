<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{   
    public function getProducts(Request $request)
    {
        $product = Product::query();

        if($request->filled('search')) {
            $product = $product->where('name', 'LIKE', '%'.$request->input('search').'%')->orWhere('brand', 'LIKE', '%'.$request->input('search').'%');
        }

        if($request->filled('category')) {
            $product = $product->where('category_id', $request->input('category'));
        }

        if($request->filled('sortBy')) {
            if($request->input('sortBy') === 'name_asc') {
                $product = $product->orderBy('name', 'asc')->paginate(20);
            }
            if($request->input('sortBy') === 'name_desc') {
                $product = $product->orderBy('name', 'desc')->paginate(20);
            }
            if($request->input('sortBy') === 'price_asc') {
                $product = $product->orderBy('price', 'asc')->paginate(20);
            }
            if($request->input('sortBy') === 'price_desc') {
                $product = $product->orderBy('price', 'desc')->paginate(20);
            }
        } else {
            $product = $product->orderBy('name', 'asc')->paginate(20);
        }

        return new ProductCollection($product);
    }

    public function store(Request $request)
    {
        //dd($request->file('image_two'));
        $product = Product::create([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'specification' => $request->input('specification'),
            'category_id' => $request->input('category_id'),
            'discount' => $request->input('discount'),
            'price' => $request->input('price'),
            'hot_deal' => $request->input('hot_deal') == 'false' ? 0 : 1,
            'new_arrival' => $request->input('new_arrival') == 'false' ? 0 : 1,
            'stock' => $request->input('stock'),
        ]);

        $inputs = [
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'specification' => $request->input('specification'),
            'category_id' => $request->input('category_id'),
            'discount' => $request->input('discount'),
            'price' => $request->input('price'),
            'hot_deal' => $request->input('hot_deal') == 'false' ? 0 : 1,
            'new_arrival' => $request->input('new_arrival') == 'false' ? 0 : 1,
            'stock' => $request->input('stock'),
        ];

        createLog($product, $inputs, 'Product Created');

        if ($request->hasFile('image_one')) {
            $product->addMedia($request->file('image_one'))->toMediaCollection('product-image-one');
        }
        if ($request->hasFile('image_two')) {
            $product->addMedia($request->file('image_two'))->toMediaCollection('product-image-two');
        }
        if ($request->hasFile('image_three')) {
            $product->addMedia($request->file('image_three'))->toMediaCollection('product-image-three');
        }
        if ($request->hasFile('image_four')) {
            $product->addMedia($request->file('image_four'))->toMediaCollection('product-image-four');
        }
        if ($request->hasFile('image_five')) {
            $product->addMedia($request->file('image_five'))->toMediaCollection('product-image-five');
        }

        return new ProductCollection(Product::orderBy('name', 'asc')->paginate(20));
    }

    public function update(Request $request, Product $product)
    {
        $product->update([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'specification' => $request->input('specification'),
            'category_id' => $request->input('category_id'),
            'discount' => $request->input('discount'),
            'price' => $request->input('price'),
            'hot_deal' => $request->input('hot_deal') == 'false' ? 1 : 0,
            'new_arrival' => $request->input('new_arrival') == 'false' ? 1 : 0,
            'stock' => $request->input('stock'),
        ]);

        $inputs = [
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'specification' => $request->input('specification'),
            'category_id' => $request->input('category_id'),
            'discount' => $request->input('discount'),
            'price' => $request->input('price'),
            'hot_deal' => $request->input('hot_deal') == 'false' ? 1 : 0,
            'new_arrival' => $request->input('new_arrival') == 'false' ? 1 : 0,
            'stock' => $request->input('stock'),
        ];

        createLog($product, $inputs, 'Product Updated');

        return new ProductCollection(Product::orderBy('name', 'asc')->paginate(20));
    }

    public function updateStock(Request $request, Product $product)
    {
        if($request->input('type') == 'add') {
            $newStock = $product->stock + $request->input('stock');
            createLog($product, ['stock' => $newStock], 'Inceasing Stock');
        } else {
            $newStock = $product->stock - $request->input('stock');
            createLog($product, ['stock' => $newStock], 'Decreasing Stock');
        }

        $product->update([
            'stock' => $newStock
        ]);

        return new ProductCollection(Product::orderBy('name', 'asc')->paginate(20));
    }
}
