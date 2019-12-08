<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{
    //
    protected $fillable = [
        'user_id', 
        'name',
        'image_preview',
        'description',
        'x',
        'y',
        'z',
        'difficulty',
        'glb_download',
        'type'
    ];
}
