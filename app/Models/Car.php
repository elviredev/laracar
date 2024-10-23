<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
   * @desc Relation one-to-one avec CarFeatures
   * @return HasOne
   */
  public function features(): HasOne
  {
    return $this->hasOne(CarFeatures::class);
  }

  /**
   * @desc Relation one-to-one avec CarImage pour afficher une seule image, celle qui est à la position la plus basse
   * @return HasOne
   */
  public function primaryImage(): HasOne
  {
    return $this->hasOne(CarImage::class)
                ->oldestOfMany('position');
  }
}
