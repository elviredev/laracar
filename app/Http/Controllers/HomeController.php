<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Support\Facades\Cache;
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
    // Sélect 30 cars publiées dans le passé, trier par desc
    // Mise en cache des datas pendant 60 sec, puis vidée du cache et reselectionnées en    bdd
    $cars = Cache::remember('home-cars', 60, function () {
      return Car::where('published_at', '<', now())
        ->with(['primaryImage', 'city', 'model', 'maker', 'carType', 'fuelType', 'favouredUsers' ])
        ->orderBy('published_at', 'desc')
        ->limit(30)
        ->get();
    });

    return view('home.index', ['cars' => $cars]);
  }
}


