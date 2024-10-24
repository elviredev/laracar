<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @mixin IdeHelperCarType
 */
class CarType extends Model
{
  use HasFactory;

  // Désactiver les colonnes timestamps (created_at et updated_at)
  public $timestamps = false;

  protected $fillable = ['name'];

  /**
   * @desc Relation one-to-many avec Cars : Un type de voiture peut être
   * associé à plusieurs voitures
   * @return HasMany
   */
  public function cars():HasMany
  {
    return $this->hasMany(Car::class);
  }
}
