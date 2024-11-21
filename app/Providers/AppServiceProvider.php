<?php

namespace App\Providers;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
      //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // vue 'pagination' par défaut utilisée pour la Pagination dans l'appli
    Paginator::defaultView('pagination');

    // variable globale accessible dans toutes les vues
    View::share('year', date('Y'));
  }
}
