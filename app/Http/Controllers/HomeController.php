<?php

namespace App\Http\Controllers;

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
    return view('home.index');
  }
}


