<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @mixin IdeHelperCity
 */
class City extends Model
{
  use HasFactory;

  // Désactiver les colonnes timestamps (created_at et updated_at)
  public $timestamps = false;

  protected $fillable = ['name', 'state_id'];

  /**
   * @desc Relation one-to-many avec State : chaque ville appartient à un état (association définie par la clé étrangère "state_id" dans "cities")
   * @return BelongsTo
   */
  public function state(): BelongsTo
  {
    return $this->belongsTo(State::class);
  }

  /**
   * @desc Relation one-to-many avec Cars : Une ville peut posséder plusieurs voitures
   * @return HasMany
   */
  public function cars():HasMany
  {
    return $this->hasMany(Car::class);
  }

}
