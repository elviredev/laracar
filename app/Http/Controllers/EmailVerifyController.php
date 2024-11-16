<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
  /**
   * @desc Sera appelé lorsque user clique sur le lien de vérification dans l'e-mail
   * @route GET /email/verify/{id}/{hash}
   * @param EmailVerificationRequest $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function verify (EmailVerificationRequest $request)
  {
    $request->fulfill();
    return redirect()->route('home')->with('success', 'Your Email was verified. You can now add cars !');
  }

  /**
   * @desc Sera appelé si on configure un middleware "verified". User vérifié pour accéder à
   * certaines routes
   * @route GET /email/verify
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
   */
  public function notice()
  {
    return view('auth.verify-email');
  }

  /**
   * @desc Sera appelé si l'utilisateur perd son lien de vérification d'email. Permet de
   * renvoyer un autre email de vérification
   * @route POST /email/verification-notification
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function send(Request $request)
  {
    /** @var User $user */
    $user = $request->user();
    $user->sendEmailVerificationNotification();

    return back()->with('success', 'Verification link sent!');
  }
}
