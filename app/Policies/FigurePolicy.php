<?php

namespace App\Policies;

use App\Figure;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

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
            $user = auth('api')->user();
            if( $user ){
                if( $user->id != $figure->user_id ){
                    return Response::deny('You can not see this figure');
                }
            } else {
               return Response::deny('You can not see this figure');
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
        //
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
        $message = 'You can not delete it. You do not own this figure: '.$figure->name;
        return $user->id == $figure->user_id ? Response::allow() : Response::deny($message);
    }

}
