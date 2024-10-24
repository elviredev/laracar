<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @mixin IdeHelperModel
 */
class Model extends EloquentModel
{
  use HasFactory;

  // Désactiver les colonnes timestamps (created_at et updated_at)
  public $timestamps = false;

  protected $fillable = ['name', 'maker_id'];

  /**
   * @desc Relation one-to-many avec Maker : chaque modèle appartient à un fabricant (association définie par la clé étrangère "maker_id" dans "models")
   * @return BelongsTo
   */
  public function maker(): BelongsTo
  {
    return $this->belongsTo(Maker::class);
  }

  /**
   * @desc Relation one-to-many avec Cars : Un modèle peut être associé plusieurs voitures
   * @return HasMany
   */
  public function cars():HasMany
  {
    return $this->hasMany(Car::class);
  }
}
