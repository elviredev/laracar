<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Models\Car;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CarController extends Controller
{
  /**
   * @desc Affiche My Cars
   * @route GET /car
   * @param Request $request
   * @return Factory|\Illuminate\Contracts\View\View|Application
   */
  public function index(Request $request)
  {
    // Select cars appartenant au user authentifié
    $cars = $request->user()
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
   * @param StoreCarRequest $request
   * @return RedirectResponse
   */
  public function store(StoreCarRequest $request): \Illuminate\Http\RedirectResponse
  {
    // Get request data
    $data = $request->validated();

    // Get features data (contient les checkboxes sélectionnées)
    $featuresData = $data['features'];
    // Get Images (si pas d'images, créer un tableau vide)
    $images = $request->file('images') ?: [];

    // Set user ID
    $data['user_id'] = Auth::id();
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
    return redirect()->route('car.index')->with('success', 'Car was created !');
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
   * @route GET /car/{id}/edit
   * @param Car $car
   * @return View
   */
  public function edit(Car $car): View
  {
    // Si car n'appartient pas au user authentifié, code 403 => forbidden
    if ($car->user_id !== Auth::id()) {
      abort(403);
    }
    return view('car.edit', ['car' => $car]);
  }

  /**
   * @desc Mettre à jour une car
   * @route PUT /car/{id}
   * @param StoreCarRequest $request
   * @param Car $car
   * @return RedirectResponse
   */
  public function update(StoreCarRequest $request, Car $car)
  {
    // Si car n'appartient pas au user authentifié, code 403 => forbidden
    if ($car->user_id !== Auth::id()) {
      abort(403);
    }

    $data = $request->validated();

    // Get features from the data
    $features = array_merge([
      'abs' => 0,
      'air_conditionning' => 0,
      'power_windows' => 0,
      'power_door_locks' => 0,
      'cruise_control' => 0,
      'bluetooth_connectivity' => 0,
      'remote_start' => 0,
      'gps_navigation' => 0,
      'heated_seats' => 0,
      'climate_control' => 0,
      'rear_parking_sensors' => 0,
      'leather_seats' => 0,
    ], $data['features'] ?? []);

    $car->update($data);

    // Update Car Features
    $car->features()->update($features);

    // redirect avec message chaque fois qu'une car est modifiée
    return redirect()->route('car.index')->with('success', 'Car was updated !');
  }

  /**
   * @desc Supprimer une car
   * @route DELETE /car/{id}
   * @param Car $car
   * @return RedirectResponse
   */
  public function destroy(Car $car): RedirectResponse
  {
    // Si car n'appartient pas au user authentifié, code 403 => forbidden
    if ($car->user_id !== Auth::id()) {
      abort(403);
    }

    $car->delete();
    return redirect()->route('car.index')->with('success', 'Car was deleted !');
  }

  /**
   * @desc Rechercher une car
   * @route GET /car/search
   * @param Request $request
   * @return View
   */
  public function search(Request $request): View
  {
    // récupérer les paramètres depuis la requête, dans URL
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
      ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model', 'favouredUsers']);

    // appliquer un filtrage sur $query
    if ($maker) {
      $query->where('maker_id', $maker);
    }
    if ($model) {
      $query->where('model_id', $model);
    }
    if ($state) {
      $query->join('cities', 'cities.id', '=', 'cars.city_id')
        ->where('cities.state_id', $state)
        ->select('cars.*');
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
    if (Str::startsWith($sort, '-')) {
      $sort = Str::substr($sort, 1);
      $query->orderBy($sort, 'desc');
    } else {
      $query->orderBy($sort);
    }

    $cars = $query->paginate(15)
    ->withQueryString();

    return view('car.search', ['cars' => $cars]);
  }


  /**
   * @desc Afficher la page des images
   * @route GET /car/{id}/images
   * @param Car $car
   * @return View
   */
  public function carImages(Car $car): View
  {
    return view('car.images', ['car' => $car]);
  }

  /**
   * @desc Modifier la position des images et supprimer image(s)
   * @route PUT /car/{id}/updateImages
   * @param Request $request
   * @param Car $car
   * @return RedirectResponse
   */
  public function updateImages(Request $request, Car $car)
  {
    // Si car n'appartient pas au user authentifié, code 403 => forbidden
    if ($car->user_id !== Auth::id()) {
      abort(403);
    }

    $data = $request->validate([
      'delete_images' => 'array',
      'delete_images.*' => 'integer',
      'positions' => 'array',
      'positions.*' => 'integer',
    ]);

    // créer 2 variables. Si elle n'existe pas, retourner tableau vide
    $deleteImages = $data['delete_images'] ?? [];
    $positions = $data['positions'] ?? [];
    // dd($deleteImages, $positions);

    // select liste d'images to delete. car, relation images() ou "id" présent dans le tableau deleteImages
    $imagestoDelete = $car->images()->whereIn('id', $deleteImages)->get();

    // iterate over images to delete and delete them from file system
    foreach ($imagestoDelete as $image) {
      if (Storage::exists($image->image_path)) {
        Storage::delete($image->image_path);
      }
    }

    // Delete images from the database
    $car->images()->whereIn('id', $deleteImages)->delete();

    // iterate over positions and update position for each image, by its ID
    foreach ($positions as $id => $position) {
      $car->images()->where('id', $id)->update(['position' => $position]);
    }

    // redirect back to car.images route
    return redirect()->back()->with('success', 'Car images were updated !');
  }

  /**
   * @desc Ajouter plus d'images à une car
   * @route POST /car/{id}/addImages
   * @param Request $request
   * @param Car $car
   * @return RedirectResponse
   */
  public function addImages(Request $request, Car $car)
  {
    // Si car n'appartient pas au user authentifié, code 403 => forbidden
    if ($car->user_id !== Auth::id()) {
      abort(403);
    }

    // Get images from request
    $images = $request->file('images') ?? [];

    // Select max position of car images in bdd
    $position = $car->images()->max('position') ?? 0;
    foreach ($images as $image) {
      // Save it on the file system
      $path = $image->store('public/images');
      // Save it in the bdd
      $car->images()->create([
        'image_path' => $path,
        'position' => $position + 1,
      ]);
      $position++;
    }

    return redirect()->back()->with('success', 'New images were added !');
  }
}
