<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $attributes = [
            'name' => $this->name,
            'description' => $this->description,
            'members' => $this->users,
            //'members' => UserResource::collection($this->users)->pluck('id'),
            'figures' => FigureResource::collection($this->figures)->pluck('id'),
        ];
        $data = [
            'group_id' => $this->id,
            'attributes' => $attributes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        return $data;
    }
}
