<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
  /**
   * @desc Affiche le détail du profil ainsi que le form de mise à jour du mdp
   * @route GET /profile
   * @return View
   */
  public function index(): View
  {
    return view('profile.index', ['user' => Auth::user()]);
  }

  /**
   * @desc Modifier le profil du user
   * @route PUT /profile
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update (Request $request)
  {
    // Define basic rules
    $rules = [
      'name' => ['required', 'string', 'max:255'],
      'phone' => ['required', 'string', 'max:255', 'unique:users,phone,' . $request->user()->id],
    ];

    // Get the current user
    $user = $request->user();
    // Add email field into rules if the user is not signed up with Google or Facebook
    if (!$user->isOauthUser()) {
      $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id];
    }

    // Perform validation
    $data = $request->validate($rules);

    // Fill the user data
    $user->fill($data);

    // Define success message
    $success = 'Your profile was updated';

    // If the email is changed we need to send email verification and we need to mark the user with email_verified_at=null
    if ($user->isDirty('email')) {
      $user->email_verified_at = null;
      $user->sendEmailVerificationNotification();
      $success = 'Email Verification was sent. Please verify !';
    }

    // Save the user
    $user->save();

    // Redirect user back to profile page with success message
    return redirect()->route('profile.index')->with('success', $success);
  }

  /**
   * @desc Modifier le mdp du user
   * @route PUT /profile/password
   * @param Request $request
   * @return RedirectResponse
   */
  public function updatePassword (Request $request)
  {
    // Validate current password and new password
    $request->validate([
      'current_password' => ['required', 'current_password'],
      'password' => ['required', 'string', 'confirmed',
        Password::min(8)
          ->max(24)
          ->numbers()
          ->mixedCase()
          ->symbols()
          ->uncompromised()]
    ]);

    // Perform password update
    $request->user()->update([
      'password' => Hash::make($request->password)
    ]);

    // Go back with success message
    return back()->with('success', 'Your password was updated');
  }
}