<?php

namespace App\Policies;

use App\Group;
use App\User;
use App\Figure;
use Illuminate\Auth\Access\HandlesAuthorization;

use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        //TODO:Refactor
       $message = 'Access denied. You are not part of this group.:(' ;
        if ($group['users']){
           return in_array($user->id, $group['users']-> pluck('id')->toArray()) ? Response::allow() : Response::deny($message);
        } 
        return Response::deny($message);       
    }


    /**
     * Determine whether the user can create groups.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        $message = 'No permissons to edit. You are not part of this group.' ;
        if ($group['users']){
           return in_array($user->id, $group['users']-> pluck('id')->toArray()) ? Response::allow() : Response::deny($message);
        } 
        return Response::deny($message);    
    }

    /**
     * Determine whether the user can add a user to the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function addUser(User $user, Group $group)
    {
        $message = 'You can not add users.You are not a creator';
        return $user->id == $group->creator_id ? Response::allow() : Response::deny($message);
    }

    /**
     * Determine whether the user can add a figure to the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function addFigure(User $user, Group $group)
    {
        $message = 'No permissons to add. You are not part of this group.' ;
        if ($group['users']){
           return in_array($user->id, $group['users']-> pluck('id')->toArray()) ? Response::allow() : Response::deny($message);
        } 
        return Response::deny($message);  
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        $message = 'You can not delete group.You are not a creator';
        return $user->id == $group->creator_id ? Response::allow() : Response::deny($message);
    }

    /**
     * Determine whether the user can delete a user.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function deleteUser(User $user, Group $group)
    {
        $message = 'You can not delete user.You are not a creator';
        return $user->id == $group->creator_id ? Response::allow() : Response::deny($message);
    }

    /**
     * Determine whether the user can delere a figure of the group.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function deleteFigure(User $user, Group $group,Figure $figure)
    {
        $message = 'You can not delete it. You do not own this resource';
        return $user->id == $figure->user_id ? Response::allow() : Response::deny($message);
    }

}
