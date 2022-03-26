<?php

namespace App\Http\Resources\Sold;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\Product as ProductResource;

class Sold extends JsonResource
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
            'cart_id' => $this->cart_id,
            'product' => $this->getProduct($this->product_id),
            'quantity' => $this->quantity,
            'method' => $this->method,
            'total_price' => $this->total_price,
        ];
    }

    public function getProduct($id)
    {
        $product = Product::where('id',  $id)->first();

        return new ProductResource($product);
    }
}
