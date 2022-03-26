<?php

namespace App\Http\Resources\Review;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\User as UserResource;

class Review extends JsonResource
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
            'stars' => $this->stars,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'user' => $this->getUser($this->user_id)
        ];
    }

    public function getUser($id)
    {
        $user = User::where('id', $id)->first();

        return new UserResource($user);
    }
}
