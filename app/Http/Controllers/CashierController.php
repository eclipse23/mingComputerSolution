<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Sold;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Resources\Cart\Cart as CartResource;
use App\Http\Resources\CartItem\CartItemCollection;

class CashierController extends Controller
{
    public function checkout(Request $request)
    {
        $myCart = Cart::create([
            'status' => 'Sold',
            'method' => 'walk-in',
            'sold_to' => $request->input('customer'),
            'date_pickup' => new Carbon(),
            'user_id' => 1
        ]);

        foreach($request->input('list') as $product) {
            
            CartItem::create([
                'cart_id' => $myCart->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['pcs']
            ]);

            $currentProduct = Product::where('id', $product['product_id'])->first();
            $currentProduct->update([
                'stock' => ($currentProduct->stock - $product['pcs']),
                'sold' => ($currentProduct->sold + $product['pcs'])
            ]);

            Sold::create([
                'product_id' => $currentProduct->id,
                'cart_id' => $myCart->id,
                'method' => 'walk-in',
                'quantity' => $product['pcs'],
                'total_price' => $product['pcs']*$currentProduct->price
            ]);
        }
        
        return $myCart;
    }

    public function receipt(Cart $cart)
    {
        $data = new CartResource($cart);
        $items = CartItem::where('cart_id', $cart->id)->with('product')->get();

        return view('cashier-reciept', ['data' => $data, 'items' => $items]);
    }
}
