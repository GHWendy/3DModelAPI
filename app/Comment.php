<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'figure_id',
        'title',
        'description'
    ];

    /**
     * Get the Figure that owns the comment
     */
    public function figure() {
        return $this->belongsTo('App\Figure');
    }
}
