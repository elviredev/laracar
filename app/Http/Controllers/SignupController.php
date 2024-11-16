<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
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

  /**
   * @desc Créer le compte d'un user en bdd
   * @route POST /signup
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    // Validate request data
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'phone' => 'required|string|max:255|unique:users,phone',
      'password' => [
        'required', 'string', 'confirmed',
        Password::min(8)
          ->max(24)
          ->numbers()
          ->mixedCase()
          ->symbols()
          ->uncompromised()
      ]
    ]);

    // Create user out of validated request data. Hash password
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'password' => Hash::make($request->password)
    ]);

    // Tente d'envoyer email de vérification
    event(new Registered($user));
    Auth::login($user);

    // Redirect to home page with flash message
    return redirect()->route('home')->with('success', 'Account created successfully. Please check your email to verify your account');
  }
}
