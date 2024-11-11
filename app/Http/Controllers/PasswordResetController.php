<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
  /**
   * @desc Afficher le formulaire de mdp oublié
   * @route GET /forgot-password
   * @return View
   */
  public function showForgotPassword(): View
  {
    return view('auth.forgot-password');
  }

  /**
   * @desc Gérer la soumission du formulaire showForgotPassword pour récupérer email
   * @route POST /forgot-password
   * @param Request $request
   * @return RedirectResponse
   */
  public function forgotPassword(Request $request)
  {
    // Validate email
    $request->validate(['email' => 'required|email']);

    // Try to send an email
    $status = Password::sendResetLink($request->only('email'));

    // If email was sent redirect user back with success message
    if ($status === Password::RESET_LINK_SENT) {
      return back()->with('success', __($status));
    }

    // If there was an error, redirect user back with email error and with email input
    return back()
      ->withErrors(['email' => __($status)])
      ->withInput($request->only('email'));
  }

  /**
   * @desc Quand user clic sur "Reset Password" dans email pour réinitialiser son mdp, affiche le
   * form pour reset mdp
   * @route GET /reset-password/{token}
   * @return View
   */
  public function showResetPassword(): View
  {
    return view('auth.reset-password');
  }

  /**
   * @desc Gérer la mise à jour du mdp et réinitialiser le nouveau mdp
   * @route POST /reset-password
   * @return RedirectResponse
   */
  public function resetPassword(Request $request)
  {
    $request->validate([
      'token' => ['required'],
      'email' => ['required', 'email'],
      'password' => ['required', 'string', 'confirmed',
        \Illuminate\Validation\Rules\Password::min(8)
          ->max(24)
          ->numbers()
          ->mixedCase()
          ->symbols()
          ->uncompromised()]
    ]);

    $status = Password::reset(
      $request->only(['email', 'password', 'password_confirmation', 'token']),
      // Le remplissage forcé remplira même les champs qui pourraient ne pas être définis dans les fillable
      function (User $user, string $password) {
        $user->forceFill([
          'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        // déclencher cet evenement
        event(new PasswordReset($user));
      }
    );
    if ($status === Password::PASSWORD_RESET) {
      return redirect()->route('login')->with('success',
        __($status));
    }

    return back()->withErrors(['email' => __($status)]);
  }
}
