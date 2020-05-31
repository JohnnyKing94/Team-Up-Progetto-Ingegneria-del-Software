<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any projects.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function edit(User $user, Project $project)
    {
        return $user->id === $project->owner_id;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Project $project)
    {
        return $user->id === $project->owner_id;
    }

    /**
     * Determine whether the user can restore the project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function restore(User $user, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function forceDelete(User $user, Project $project)
    {
        //
    }
}
