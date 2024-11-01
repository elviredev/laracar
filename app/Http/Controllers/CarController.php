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
      ->with(['primaryImage', 'model', 'maker'])
      ->orderBy('created_at', 'desc')
      ->paginate(15);

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
   * @param Request $request
   * @return View
   */
  public function search(Request $request): View
  {
    // récupérer les paramètrs depuis la requête
    $maker = $request->integer('maker_id');
    $model = $request->integer('model_id');
    $carType = $request->integer('car_type_id');
    $fuelType = $request->integer('fuel_type_id');
    $state = $request->integer('state_id');
    $city = $request->integer('city_id');
    $yearFrom = $request->integer('year_from');
    $yearTo = $request->integer('year_to');
    $priceFrom = $request->integer('price_from');
    $priceTo = $request->integer('price_to');
    $mileage = $request->integer('mileage');

    $query = Car::where('published_at', '<', now())
      ->with(['primaryImage', 'model', 'maker', 'city', 'carType', 'fuelType'])
      ->orderBy('published_at', 'desc');

    // appliquer un filtrage sur $query
    if ($maker) {
      $query->where('maker_id', $maker);
    }
    if ($model) {
      $query->where('model_id', $model);
    }
    if ($state) {
      $query->join('cities', 'cities.id', '=', 'cars.city_id')
        ->where('cities.state_id', $state);
    }
    if ($city) {
      $query->where('city_id', $city);
    }
    if ($carType) {
      $query->where('car_type_id', $carType);
    }
    if ($fuelType) {
      $query->where('fuel_type_id', $fuelType);
    }
    if ($yearFrom) {
      $query->where('year', '>=', $yearFrom);
    }
    if ($yearTo) {
      $query->where('year', '<=', $yearTo);
    }
    if ($priceFrom) {
      $query->where('price', '>=', $priceFrom);
    }
    if ($priceTo) {
      $query->where('price', '<=', $priceTo);
    }
    if ($mileage) {
      $query->where('mileage', '<=', $mileage);
    }

    $cars = $query->paginate(15);

    return view('car.search', ['cars' => $cars]);
  }

  /**
   * @desc Afficher les favoris d'un user
   * @route GET /car/watchlist
   * @return View
   */
  public function watchlist(): View
  {
    // TODO we come back to this
    $cars = User::find(4)
      ->favouriteCars()
      ->with(['primaryImage', 'city', 'model', 'maker', 'carType', 'fuelType' ])
      ->paginate(15);

    return view('car.watchlist', ['cars' => $cars]);
  }
}
