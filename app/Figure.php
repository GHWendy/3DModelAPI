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
     * Detach all  groups from a figure
     */
    public function detachGroups(Figure $figure)
    {
        foreach ($figure->groups as $group) {
            $figure->groups()->detach($group->id);
        }
    }

    /**
     * Delete comments from a figure
     */
    public function deleteComments(Figure $figure) {
        foreach ($figure->comments as $comment) {
            //$figure->$comment->dissociate();
            $comment->delete();
        }
    }

}
