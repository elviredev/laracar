<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperCar
 */
class Car extends Model
{
  use HasFactory, SoftDeletes;
  protected $fillable = [
    'maker_id',
    'model_id',
    'year',
    'price',
    'vin',
    'mileage',
    'car_type_id',
    'fuel_type_id',
    'user_id',
    'city_id',
    'address',
    'phone',
    'description',
    'published_at',
  ];

  /**
   * @desc Relation one-to-many avec CarType : chaque voiture est associée à un seul type
   * de voiture (association définie par la clé étrangère "car_type_id" dans "cars")
   * @return BelongsTo
   */
  public function carType(): BelongsTo
  {
    return $this->belongsTo(CarType::class);
  }

  /**
   * @desc Relation one-to-many avec FuelType : chaque voiture est associée à un seul
   * carburant (association définie par la clé étrangère "fuel_type_id" dans "cars")
   * @return BelongsTo
   */
  public function fuelType(): BelongsTo
  {
    return $this->belongsTo(FuelType::class);
  }

  /**
   * @desc Relation one-to-many avec Maker : chaque voiture est associée à un seul
   *  fabricant (association définie par la clé étrangère "maker_id" dans "cars")
   * @return BelongsTo
   */
  public function maker(): BelongsTo
  {
    return $this->belongsTo(Maker::class);
  }

  /**
   * @desc Relation one-to-many avec Model : chaque voiture est associée à un seul
   *  modèle (association définie par la clé étrangère "model_id" dans "cars")
   * @return BelongsTo
   */
  public function model(): BelongsTo
  {
    return $this->belongsTo(\App\Models\Model::class);
  }

  /**
   * @desc Relation one-to-many avec User : chaque voiture appartient à un seul
   *  propriétaire (association définie par la clé étrangère "user_id" dans "cars")
   * @return BelongsTo
   */
  public function owner(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * @desc Relation one-to-many avec City : chaque voiture est localisée dans une seule
   *  ville (association définie par la clé étrangère "city_id" dans "cars")
   * @return BelongsTo
   */
  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class);
  }

  /**
   * @desc Relation one-to-one avec CarFeatures : une voiture possède un seul ensemble de caractéristiques
   * @return HasOne
   */
  public function features(): HasOne
  {
    return $this->hasOne(CarFeatures::class);
  }

  /**
   * @desc Relation one-to-one avec CarImage pour récupérer une seule image, celle qui est à la position la plus basse
   * @return HasOne
   */
  public function primaryImage(): HasOne
  {
    return $this->hasOne(CarImage::class)
                ->oldestOfMany('position');
  }

  /**
   * @desc Relation one-to-many avec CarImage : une voiture peut posséder plusieurs images mais chaque image est
   * associée à une seule voiture
   * @return HasMany
   */
  public function images(): HasMany
  {
    return $this->hasMany(CarImage::class)->orderBy('position');
  }

  /**
   * @desc Relation many-to-many avec User sur la table pivot 'favourite_cars'
   * Une voiture peut être marquée comme favori par plusieurs utilisateurs.
   * @return BelongsToMany
   */
  public function favouredUsers(): BelongsToMany
  {
    return $this->belongsToMany(User::class, 'favourite_cars');
  }

  /**
   * Retourne la date au format 2024-10-29
   * @return string
   */
  public function getCreateDate(): string
  {
    return (new Carbon($this->created_at))->format('Y-m-d');
  }

  /**
   * Permet d'afficher un titre tel que 2024 - Ford Mustang
   * @return string
   */
  public function getTitle()
  {
    return $this->year . ' - ' . $this->maker->name . ' ' . $this->model->name;
  }

  /**
   * @desc Cette voiture est mise en favori par cet utilisateur ou pas.
   * Pour prendre en compte un Guest, on ajoute "null" par défaut
   * @param User|null $user
   * @return mixed
   */
  public function isInWatchlist (User $user = null)
  {
    return $this->favouredUsers->contains($user);
  }
}
