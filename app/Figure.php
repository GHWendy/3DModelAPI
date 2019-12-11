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

    /**
     * Get the comments fot the figure
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
        //return $this->belongsToMany('App\User', 'comments')->withPivot('id', 'title', 'description')->as('comment')->withTimestamps();
    }
}
