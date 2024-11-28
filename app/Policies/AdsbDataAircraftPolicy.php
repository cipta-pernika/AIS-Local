<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdsbDataAircraft;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdsbDataAircraftPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AdsbDataAircraft $adsbDataAircraft): bool
    {
        return $user->can('view_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AdsbDataAircraft $adsbDataAircraft): bool
    {
        return $user->can('update_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AdsbDataAircraft $adsbDataAircraft): bool
    {
        return $user->can('delete_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, AdsbDataAircraft $adsbDataAircraft): bool
    {
        return $user->can('force_delete_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, AdsbDataAircraft $adsbDataAircraft): bool
    {
        return $user->can('restore_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, AdsbDataAircraft $adsbDataAircraft): bool
    {
        return $user->can('replicate_adsb::data::aircraft');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_adsb::data::aircraft');
    }
}
