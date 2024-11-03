<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
    $cars = User::find(1)
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
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): \Illuminate\Http\RedirectResponse
  {
    // Get request data
    $data = $request->all();
    // Get features data (contient les checkboxes sélectionnées)
    $featuresData = $data['features'];
    // Get Images (si pas d'images, créer un tableau vide)
    $images = $request->file('images') ?: [];

    // Set user ID
    $data['user_id'] = 1;
    // Create new car
    $car = Car::create($data);

    // Create features
    $car->features()->create($featuresData);

    // Iterate and create images
    foreach ($images as $i => $image) {
      // save image dans le repertoire public
      $path = $image->store('public/images');
      // create record in bdd
      $car->images()->create(['image_path' => $path, 'position' => $i + 1]);
    }

    // Redirect to car.index route
    return redirect()->route('car.index');
  }

  /**
   * @desc Affiche une car spécifique
   * @route GET /car/{$id}
   * @param Car $car
   * @return View
   */
  public function show(Car $car): View
  {
    // Ne pas afficher la page de details quand car non publiée
    if (!$car->published_at) {
      abort(404);
    }
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
    // récupérer les paramètrs depuis la requête, dans URL
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

    // 1- Sorting Cars
    // récupérer le query de tri "sort" et s'il n'existe pas, prendre "-published_at"
    $sort = $request->input('sort', '-published_at');

    $query = Car::where('published_at', '<', now())
      ->with(['primaryImage', 'model', 'maker', 'city', 'carType', 'fuelType']);

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

    // 2- Sorting Cars
    // si "sort" commence par "-"
    if (str_starts_with($sort, '-')) {
      $sort = substr($sort, 1);
      $query->orderBy($sort, 'desc');
    } else {
      $query->orderBy($sort);
    }

    $cars = $query->paginate(15)
    ->withQueryString();

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
