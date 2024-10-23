<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarController extends Controller
{
  /**
   * @desc Affiche My Cars
   * @route GET /car
   * @return View
   */
  public function index(): View
  {
      return view('car.index');
  }

  /**
   * @desc Affiche le formulaire pour créer une nouvelle car
   * @route GET /car/create
   * @return View
   */
  public function create(): View
  {
      return view('car.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * @desc Affiche une car spécifique
   * @route GET /car/{$id}
   * @param Car $car
   * @return View
   */
  public function show(Car $car): View
  {
      return view('car.show');
  }

  /**
   * @desc Affiche le formulaire pour modifier une car
   * @route GET /car/{$id}/edit
   * @param Car $car
   * @return View
   */
  public function edit(Car $car): View
  {
      return view('car.edit');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Car $car)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Car $car): View
  {
      //
  }

  /**
   * @desc Rechercher une car
   * @route GET /car/search
   * @return View
   */
  public function search(): View
  {
    return view('car.search');
  }
}
