<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('Administrator')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  User $user
     * @param  User $target
     * @return mixed
     */
    public function view(User $user, User $target)
    {
        return $user->id === $target->id || $user->hasPermissionTo('view-other-users');
    }

    /**
     * Determine whether the user can edit the user.
     *
     * @param  User $user
     * @param  User $target
     * @return mixed
     */
    public function edit(User $user, User $target)
    {
        return $this->view($user, $target) && $this->update($user, $target);
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  User $user
     * @param  User $target
     * @return mixed
     */
    public function update(User $user, User $target)
    {
        return $user->id === $target->id || $user->hasPermissionTo('update-other-users');
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  User $user
     * @param  User $user
     * @return mixed
     */
    public function delete(User $user, User $target)
    {
        return $user->id === $target->id || $user->hasPermissionTo('delete-other-users');
    }
}
