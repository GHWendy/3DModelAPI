<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    
    protected $fillable = [
        'name',
        'description',
        'members',
        'figures',
    ];

    /**
     * Get the figures for the group
     */
    public function figures()
    {
        return $this->belongsToMany('App\Figure', 'figures_groups')->withTimestamps();
    }

    /**
     * Get the users for the group
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'users_groups')->withTimestamps();
    }


}
