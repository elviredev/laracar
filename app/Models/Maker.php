<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @mixin IdeHelperMaker
 */
class Maker extends Model
{
  use HasFactory;

  // Désactiver les colonnes timestamps (created_at et updated_at)
  public $timestamps = false;

  protected $fillable = ['name'];

  /**
   * @desc Relation one-to-many avec Cars : Un fabricant peut posséder plusieurs voitures
   * @return HasMany
   */
  public function cars():HasMany
  {
    return $this->hasMany(Car::class);
  }

  /**
   * @desc Relation one-to-many avec Cars : Un fabricant peut posséder plusieurs modèles de voiture
   * @return HasMany
   */
  public function models():HasMany
  {
    return $this->hasMany(\App\Models\Model::class);
  }
}
