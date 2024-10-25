<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Maker;
use App\Models\Model;
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
//    Model::factory()
//      ->count(5)
//      ->forMaker(['name' => 'Lexus'])
//      ->create();

    // relation many to many
    // créer un user avec 5 cars et ajouter ces 5 cars dans table pivot favourite_cars
//    User::factory()
//      ->has(Car::factory()->count(5), 'favouriteCars')
//      ->create();

    return view('home.index');
  }
}


