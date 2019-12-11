<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentResource;

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
            'comment_id' => $this->id,
            'user_id' => $this->user_id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->description
            ],
            'created_at' => $this->created_at,
            'update_at' => $this->updated_at
        ];
    }
}
