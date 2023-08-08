<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'name' => $this->name,//getNameAttribute()から返る
            'email' => $this->email,
            'total' => $this->total,//getTotalAttributek()から返る
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}
