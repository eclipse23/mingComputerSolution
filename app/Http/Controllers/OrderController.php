<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Sold;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use App\Events\UpateProduct;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Events\UserNotification;
use App\Events\UpdateProductView;
use App\Http\Resources\Cart\CartCollection;

class OrderController extends Controller
{
    public function list()
    {
        return view('backend.orders');
    }

    public function allOrders(Request $request)
    {
        $cart = Cart::query();

        $cart = $cart->where('status', '!=', 'unprocess');

        if($request->filled('search')) {
            $cart = $cart->where('id', 'LIKE', '%'.$request->input('search').'%')->orderBy('id', 'desc');
        } 

        if($request->filled('paymentMethod')) {
            $cart = $cart->where('method', $request->input('paymentMethod'));
        } 

        if($request->filled('status')) {
            $cart = $cart->where('status', $request->input('status'));
        } 
        
        $cart = $cart->orderBy('id', 'desc')->get();

        return new CartCollection($cart);
    }

    public function cartChangeStatus(Request $request, Cart $cart)
    {
        if($request->input('status') == "Sold") {
            if($cart->method == 'pick-up') {
                $items = CartItem::where('cart_id', $cart->id)->get();
                foreach($items as $item) {
                    $product = Product::where('id', $item->product->id)->first();
                    $product->update([
                        'stock' => ($product->stock - $item->quantity),
                        'sold' => $product->sold + $item->quantity,
                        'reserved' => $product->reserved - $item->quantity
                    ]);
                    Sold::create([
                        'product_id' => $item->product->id,
                        'cart_id' => $cart->id,
                        'method' => $cart->method,
                        'quantity' => $item->quantity,
                        'total_price' => ($item->quantity*$product->price)
                    ]);
    
                    $recommendation = Recommendation::where('user_id', $cart->user_id)->where('product_id', $product->id)->get();
                    
                    if(count($recommendation) == 0) {
                        Recommendation::create([
                            'user_id' => $cart->user_id,
                            'product_id' => $product->id,
                            'score' => 1
                        ]);
                    }
                }
            }
        
            $cart->update([
                'status' => $request->input('status'),
                'date_pickup' => Carbon::now()
            ]);
        } else {
            $cart->update([
                'status' => $request->input('status')
            ]);
            $notification = Notification::where('user_id', $cart->user_id)->first();
            
            $notification->update([
                'order' =>  $notification->order + 1
            ]);

            $user = User::where('id', $cart->user_id)->first();
            broadcast(new UserNotification($user))->toOthers();
        }

        $carts = Cart::where('status', '!=', 'unprocess')->orderBy('id', 'desc')->get();

        return new CartCollection($carts);
    }
    
    public function customerOrdersView()
    {
        return view('frontend.orders');
    }

    public function customerOrders()
    {
        $cart = Cart::where('status', '!=', 'unprocess')->where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        return new CartCollection($cart);
    }
    

    public function cancelOrder(Cart $cart)
    {
        $items = CartItem::where('cart_id', $cart->id)->get();
        foreach($items as $item) {
            $product = Product::where('id', $item->product_id)->first();
            $product->update([
                'reserved' => $product->reserved - $item->quantity
            ]);
            broadcast(new UpdateProductView($product))->toOthers();
            broadcast(new UpateProduct())->toOthers();
        }

        return $cart->update([
            'status' => 'cancelled'
        ]);
    }

    public function pendingOrders()
    {
        $cart = Cart::where('status', 'processing')->orderBy('id', 'desc')->count();

        return response()->json($cart);
    }
}
