<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    
    protected $fillable = [
        'name',
        'description',
        'creator_id',
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

    /**
     * Detach all  users from a group
     */
    public function detachUsers(Group $group)
    {
        foreach ($groups->users as $user) {
            $group->users()->detach($user->id);
        }
    }

    /**
     * Detach all  figures from a group
     */
    public function detachFigures(Group $group)
    {
        foreach ($groups->figures as $figure) {
            $group->figures()->detach($figure->id);
        }
    }

}
