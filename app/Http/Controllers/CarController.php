<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarController extends Controller
{
  /**
   * @desc Affiche My Cars
   * @route GET /car
   * @return View
   */
  public function index(): View
  {
    // Select cars appartenant au user authentifié
    $cars = User::find(4)
      ->cars()
      ->orderBy('created_at', 'desc')
      ->get();

    return view('car.index', ['cars' => $cars]);
  }

  /**
   * @desc Affiche le formulaire pour créer une nouvelle car
   * @route GET /car/create
   * @return View
   */
  public function create(): View
  {
      return view('car.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * @desc Affiche une car spécifique
   * @route GET /car/{$id}
   * @param Car $car
   * @return View
   */
  public function show(Car $car): View
  {
      return view('car.show', ['car' => $car]);
  }

  /**
   * @desc Affiche le formulaire pour modifier une car
   * @route GET /car/{$id}/edit
   * @param Car $car
   * @return View
   */
  public function edit(Car $car): View
  {
      return view('car.edit');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Car $car)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Car $car): View
  {
    //
  }

  /**
   * @desc Rechercher une car
   * @route GET /car/search
   * @return View
   */
  public function search(): View
  {
    $query = Car::where('published_at', '<', now())
      ->orderby('published_at', 'desc');

    $carCount = $query->count();

    $cars = $query->limit(30)->get();

    return view('car.search', ['cars' => $cars, 'carCount' => $carCount]);
  }

  /**
   * @desc Afficher les favoris d'un user
   * @route GET /car/watchlist
   * @return View
   */
  public function watchlist(): View
  {
    // TODO we come back to this
    $cars = User::find(4)->favouriteCars;

    return view('car.watchlist', ['cars' => $cars]);
  }
}
