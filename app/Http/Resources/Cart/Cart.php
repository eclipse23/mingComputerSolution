<?php

namespace App\Http\Resources\Cart;

use App\Models\CartItem;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CartItem\CartItemCollection;

class Cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'user' => $this->user,
            'sold_to' => $this->sold_to,
            'method' => $this->method,
            'orders' => $this->getProducts($this->id)
        ];
    }

    public function getPRoducts($id)
    {
        $items = CartItem::where('cart_id', $id)->get();

        return new CartItemCollection($items);
    }
}
