<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

  public function redirectToProvider ($provider)
  {
    // redirection appropriée vers le fournisseur oauth
    return Socialite::driver($provider)->redirect();
  }

  public function handleCallback ($provider) {
    // Gère l'authentification réussie
    // Mettre tout en try catch pour des raisons de sécurité
    try {
      // Définir le champ de la table users qui doit être mis à jour
      $field = null;

      // En fonction du fournisseur, définir la valeur correcte du champs
      if ($provider === 'google') {
        $field = 'google_id';
      } elseif($provider === 'facebook') {
        $field = 'facebook_id';
      }

      // Obtenir les informations utilisateur auprès du fournisseur
      $user = Socialite::driver($provider)->stateless()->user();

      // En fonction de l'adresse e-mail, sélectionnez le user dans la bdd
      $dbUser = User::where('email', $user->email)->first();

      /* Si user existe déjà dans en bdd car il a créé son compte avec son email (pas avec google ni facebook) et il tente de se connecter avec google ou fb.
       On va mettre à jour la colonne google_id ou facebook_id avec son user ID  */
      if ($dbUser) {
        $dbUser->$field = $user->id;
        $dbUser->save();
      } else {
        // Si user n'existe pas, on le créé
        $dbUser = User::create([
          'name' => $user->name,
          'email' => $user->email,
          $field => $user->id,
          'email_verified_at' => now()
        ]);
      }
      // Marquer le User comme authentifié
      Auth::login($dbUser);

      // Et redirigez vers la page prévue ou vers la page d'accueil
      return redirect()->intended(route('home'));

    } catch(\Exception $e) {
      // Si erreur redirect user vers page login et afficher message d'erreur
      return redirect(route('login'))
        ->with('error', $e->getMessage() ?: 'Something went wrong');
    }
  }
}
