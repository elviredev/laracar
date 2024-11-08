<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

  /**
   * @desc Authentifier user
   * @route POST /login
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    // Get Validated data
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    // Try to authenticate with given email and password
    if (Auth::attempt($credentials)) {
      // If that was successful, regenerate session
      $request->session()->regenerate();
      // and redirect user to home page. But if user is coming from another page to login page, redirect to that intended page
      return redirect()
          ->intended(route('home'))
          ->with('success', 'Welcome Back');
    }
    // If attempt was not successful, redirect back into login form with error on email and with email input data
    return redirect()->back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
  }

  /**
   * @desc Logout User
   * @route POST /logout
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function logout(Request $request)
  {
    // Logout user
    Auth::logout();
    // Regenerate session
    $request->session()->regenerate();
    // Regenerate CSRF Token
    $request->session()->regenerateToken();

    return redirect()->route('home');
  }
}
