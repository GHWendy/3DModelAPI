<?php

namespace App\Policies;

use App\Figure;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
    public function view(User $user, Figure $figure)
    {
        return $user->id == $figure->user_id;
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
        return $user->id == $figure->user_id;
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
        //
    }

    /**
     * Determine whether the user can restore the figure.
     *
     * @param  \App\User  $user
     * @param  \App\Figure  $figure
     * @return mixed
     */
    public function restore(User $user, Figure $figure)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the figure.
     *
     * @param  \App\User  $user
     * @param  \App\Figure  $figure
     * @return mixed
     */
    public function forceDelete(User $user, Figure $figure)
    {
        //
    }
}
