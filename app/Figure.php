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
     * Get the comments for the figure
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the groups for the figure
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group', 'figures_groups');
    }

    /**
     * Get the users if the figure is in a group
     */
    /*public function usersGroup()
    {
        return $this->hasManyThrough('App\User', 'App\Group');
    }*/
}
