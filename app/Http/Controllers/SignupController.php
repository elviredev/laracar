<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SignupController extends Controller
{
  /**
   * @desc Affiche le formulaire d'inscription
   * @route GET /signup
   * @return View
   */
  public function create(): View
  {
    return view('auth.signup');
  }
}
