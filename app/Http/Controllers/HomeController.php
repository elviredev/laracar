<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarFeatures;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
  /**
   * @desc Affiche Homepage
   * @route GET /
   * @return View
   */
  public function index(): View
  {
//    $car = Car::find(2);
//    dump($car->features, $car->primaryImage);
////    $car->features->abs = 0;
////    $car->features->save();
//    $car->features->update(['abs' => 0]);
//
//    $car->primaryImage->delete();

//    $car = Car::find(3);
//
//    $carFeatures = new CarFeatures(
//      [
//        'abs' => false,
//        'air_conditionning' => false,
//        'power_windows' => false,
//        'power_door_locks' => false,
//        'cruise_control' => false,
//        'bluetooth_connectivity' => false,
//        'remote_start' => false,
//        'gps_navigation' => false,
//        'heated_seats' => false,
//        'climate_control' => false,
//        'rear_parking_sensors' => false,
//        'leather_seats' => false
//      ]
//    );
//
//    $car->features()->save($carFeatures);

      // Create new image
//      $image = new CarImage(['image_path' => 'something', 'position' => 2]);
//      $car->images()->save($image);
//
//      $car->images()->create(['image_path' => 'something 2', 'position' => 3]);

//        $car->images()->saveMany([
//          new CarImage(['image_path' => 'something 3', 'position' => 4]),
//          new CarImage(['image_path' => 'something 4', 'position' => 5]),
//        ]);
//
//        $car->images()->createMany([
//          ['image_path' => 'something 5', 'position' => 6],
//          ['image_path' => 'something 6', 'position' => 7],
//        ]);

//        $car = Car::find(2);
//        dd($car->carType);
//          $carType = CarType::where('name', 'Hatchback')->first();
//          $cars = $carType->cars;
//          dd($cars);
//          $cars = Car::whereBelongsTo($carType)->get();
//          dump($cars);

//    $car = Car::find(2);
//    $carType = CarType::where('name', 'Sedan')->first();

//    $car->car_type_id = $carType->id;
//    $car->save();

//    $car->carType()->associate($carType);
//    $car->save();

//    $car = Car::find(2);
//    dd($car->favouredUsers);

//    $user = User::find(1);
//    dd($user->favouriteCars);

//    $user = User::find(1);
////    $user->favouriteCars()->attach([2, 3]);
//    // delete les valeurs existantes et en créé une nouvelle
//    $user->favouriteCars()->sync([4]);

//    $user->favouriteCars()->detach([1, 2]);



   return view('home.index');
  }
}


