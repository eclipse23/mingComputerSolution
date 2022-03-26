<?php

namespace App\Http\Controllers;

use App\Events\CustomerOrders;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Events\UpateProduct;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Events\UserNotification;
use App\Events\UpdateProductView;
use App\Http\Resources\CartItem\CartItemCollection;

class CartController extends Controller
{
    public function list()
    {
        return view('frontend.cart');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'unprocess')->get();

        if(count($cart) == 0) {
            $myCart = Cart::create([
                'status' => 'unprocess',
                'sold_to' => $user->name,
                'user_id' => $user->id
            ]);
        } else {
            $myCart = $cart[0];
        }

        CartItem::create([
            'cart_id' => $myCart->id,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity')
        ]);

        $product = Product::where('id', $request->input('product_id'))->first();
        storeRecommendation($product);

        $product->update([
            'reserved' => $product->reserved + $request->input('quantity')
        ]);

        broadcast(new UpdateProductView($product))->toOthers();
        broadcast(new UpateProduct())->toOthers();
        broadcast(new UserNotification($user))->toOthers();
        return 'product added to cart';
    }

    public function myCart()
    {
        $items = [];
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'unprocess')->get();
        if(count($cart) == 0) {
            $myCart = [];
        } else {
            $myCart = $cart[0];
            $items = CartItem::where('cart_id', $myCart->id)->get();
        }

        return new CartItemCollection($items);
    }

    public function destroyItem(CartItem $cartItem)
    {
        $product = Product::where('id', $cartItem->product_id)->first();
        
        $product->update([
            'reserved' => $product->reserved - $cartItem->quantity
        ]);

        broadcast(new UpdateProductView($product))->toOthers();
        broadcast(new UpateProduct())->toOthers();
        $cartItem->delete();

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'unprocess')->get();
        if(count($cart) == 0) {
            $myCart = [];
        } else {
            $myCart = $cart[0];
        }

        $items = CartItem::where('cart_id', $myCart->id)->get();

        return new CartItemCollection($items);
    }

    public function myCartCheckout()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'unprocess')->first();

        foreach($cart->cartItems as $item) {
            $product = Product::where('id', $item->product_id)->first();
            storeRecommendation($product);
        }

        $cart->update([
            'status' => 'processing',
            'method' => 'pick-up'
        ]);

        $items = [];

        broadcast(new CustomerOrders($user))->toOthers();
        return new CartItemCollection($items);
    }

    public function addQuantity(Request $request)
    {
        $cartItem = CartItem::where('id', $request->input('item_id'))->first();
        $product = Product::where('id', $cartItem->product_id)->first();
        $reserved = $product->reserved - $cartItem->quantity;

        $cartItem->update([
            'quantity' => $request->input('quantity')
        ]);

        $product->update([
            'reserved' => $reserved + $request->input('quantity')
        ]);

        broadcast(new UpdateProductView($product))->toOthers();
        broadcast(new UpateProduct())->toOthers();

        return;
    }
}
