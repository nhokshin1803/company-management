<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'detail' => $this->detail,
            'card_id' => $this->card_id,
            'is_disabled' => $this->is_disabled,
            'user_id' => $this->user_id,
        ];
    }
}
