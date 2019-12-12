<?php

namespace App\Policies;

use App\Figure;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class FigurePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any figures.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the figure.
     *
     * @param  \App\User  $user
     * @param  \App\Figure  $figure
     * @return mixed
     */
    public function view(?User $user, Figure $figure)
    {
        if( $figure->type == 'private' ){
            if( $user ){
                if( $user->id != $figure->user_id ){
                    return Response::deny('You do not have access to this figure');
                }
            } else {
               return Response::deny('You do not have access to this figure');
            }
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create figures.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the figure.
     *
     * @param  \App\User  $user
     * @param  \App\Figure  $figure
     * @return mixed
     */
    public function update(User $user, Figure $figure)
    {
        $message = 'You can not edit it. You do not own this figure: '.$figure->name;
        return $user->id == $figure->user_id ? Response::allow() : Response::deny($message);
    }

    /**
     * Determine whether the user can delete the figure.
     *
     * @param  \App\User  $user
     * @param  \App\Figure  $figure
     * @return mixed
     */
    public function delete(User $user, Figure $figure)
    {
        $message = 'You can not delete it. You do not own this resource';
        return $user->id == $figure->user_id ? Response::allow() : Response::deny($message);
    }

    public function updateWhenIsInAGroup(User $user)
    {

    }
    
    public function accessWhenIsInAGroup(User $user, Figure $figure)
    {
        $bol = User::join('users_groups', 'users.id', '=', 'users_groups.user_id')
                ->join('groups', 'users_groups.group_id', '=', 'groups.id')
                ->join('figures_groups', 'groups.id', '=', 'figures_groups.group_id')
                ->join('figures', 'figures_groups.figure_id', '=', 'figures.id')
                ->where([['users.id', $user->id],['figures.id', $figure->id]])
                ->exists();
        return $bol ? Response::Allow() : Response::deny('You do not have access to this figure');
    }

    public function editType(User $user, Figure $figure)
    {
        $bol = DB::table('figures_groups')->where('figure_id', $figure->id)->doesntExist();
        return $bol ? Response::Allow() : Response::deny('You cannot change the figure type when is in a group');
    }
}
