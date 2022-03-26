<?php

namespace App\Http\Resources\CartItem;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\Product as ProductResource;

class CartItem extends JsonResource
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
            'quantity' => $this->quantity,
            'product' => $this->getProduct($this->product_id),
            'has_review' => $this->checkHasReview($this->cart_id, $this->product_id)
        ];
    }

    public function getProduct($id)
    {
        $product = Product::where('id',  $id)->first();

        return new ProductResource($product);
    }

    public function checkHasReview($cart_id, $product_id)
    {
        $review = Review::where('product_id', $product_id)->where('cart_id', $cart_id)->exists();

        return $review;
    }
}
