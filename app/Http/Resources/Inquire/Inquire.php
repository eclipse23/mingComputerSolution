<?php

namespace App\Http\Resources\Inquire;

use Illuminate\Http\Resources\Json\JsonResource;

class Inquire extends JsonResource
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
            'message' => $this->message,
            'replies' => $this->replyInquires,
            'product' => $this->product,
            'updated_at' => $this->updated_at,
            'unseen' => $this->unseen,
            'user' => $this->user,
            'user_last_message' => $this->user_last_message
        ];
    }
}
