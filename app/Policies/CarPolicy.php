<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CarPolicy
{
    /**
     * Determine si le user peut créer un nouveau model, une nouvelle car.
     * Si tel renseigné dans son profil, il est autorisé
     */
    public function create(User $user): bool
    {
        return !!$user->phone; // convertit l'existence du tel en true ou false
    }

    /**
     * Determine si le user peut modifier le model.
     */
    public function update(User $user, Car $car): Response
    {
        return $user->id === $car->user_id
        ? Response::allow()
        : Response::denyWithStatus(404);
    }

    /**
     * Determine si le user peut supprimer le model.
     */
    public function delete(User $user, Car $car): Response
    {
      return $user->id === $car->user_id
        ? Response::allow()
        : Response::denyWithStatus(404);
    }

}
