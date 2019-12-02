<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FigureResource extends JsonResource
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
            'figure_id' => $this->id,
            'user_id' => $this->user_id,
            'attributes' => [
                'name' => $this->name,
                'image_preview' => $this->image_preview,
                'description' => $this->description,
                'dimensions' => [
                    'x' => $this->x,
                    'y' => $this->y,
                    'z' => $this->z
                ],
                //'tags' => [1,2,3], //Not yet implemented and maybe we are not going to do it
                'difficulty' => $this->difficulty,
                'glb_download' => $this->glb_download,
                'type' => $this->type
            ],
        ];
    }
}
