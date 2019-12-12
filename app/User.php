<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
class User extends Authenticatable implements AuthenticatableInterface 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getApiToken()
    {
        return $this->api_token;
    }
    /**
     * Get the figures of the user
     */
    public function figures()
    {
        return $this->hasMany('App\Figure');
    }

    /**
     * Get the comments of the user
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the groups created by the user
     */
    public function myCreatedGroups()
    {
        return $this->hasMany('App\Group', 'creator_id');
    }

    /**
     * Get the groups of the user
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group', 'users_groups');
    }

    /**
     * Delete all figures made from a given user
     */
    public function deleteFigures(User $user)
    {
        return $user->figures;
        foreach($user->figures as $figure)
        {
            $figure->detachGroups($figure);
            $figure->deleteComments($figure);
            $figure->delete();
        }
    }

    /**
     * Delete all groups made from a given user
     */
    public function deleteGroups(User $user)
    {
        foreach($user->myCreatedGroups as $group){
            $group->detachUsers($group);
            $group->detachFigures($group);
            $group->delete();
        }
    }

    /**
     * Detach all  groups from a user
     */
    public function detachGroups(User $user)
    {
        return $user->groups;
        foreach ($user->groups as $group) {
            $user->groups()->detach($group->id);
        }
    }

    /**
     * Delete comments made from a given user
     */
    public function deleteComments(User $user) {
        return $user->comments;
        foreach ($user->comments as $comment) {
            //$figure->$comment->dissociate();
            $comment->delete();
        }
    }
}
