<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
  /**
   * @desc Afficher cars dans les favoris pour les users authentifiés
   * @route GET /watchlist
   * @return View
   */
  public function index (): View
  {
    $cars = Auth::user()
      ->favouriteCars()
      ->with(['primaryImage', 'city', 'model', 'maker', 'carType', 'fuelType' ])
      ->paginate(15);

    return view('watchlist.index', ['cars' => $cars]);
  }

  /**
   * @desc Ajouter et Supprimer car dans les favoris
   * @route POST /watchlist/{car}
   * @param Car $car
   * @return \Illuminate\Http\JsonResponse
   */
  public function storeDestroy(Car $car)
  {
    // Get the authenticated user
    $user = Auth::user();

    // Check if the current car is already added into favourite cars
    $carExists = $user->favouriteCars()->where('car_id', $car->id)->exists();

    // Remove if it exists
    if ($carExists) {
      $user->favouriteCars()->detach($car);
      // Response to request Axios in app.js method initAddToWatchlist()
      return response()->json([
        'added' => false,
        'message' => 'Car was removed from watchlist'
      ]);
    }

    // Add the car into favourite cars of the user
    $user->favouriteCars()->attach($car);
    // Response to request Axios in app.js method initAddToWatchlist()
    return response()->json([
      'added' => true,
      'message' => 'Car was added to watchlist'
    ]);
  }
}
