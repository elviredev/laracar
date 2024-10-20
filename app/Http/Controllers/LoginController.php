<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LoginController extends Controller
{
  /**
   * @desc Affiche page de connexion
   * @route GET /login
   * @return View
   */
  public function create(): View
  {
    return view('auth.login');
  }
}
