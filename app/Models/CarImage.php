<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @mixin IdeHelperCarImage
 */
class CarImage extends Model
{
  use HasFactory;

  // Désactiver les colonnes timestamps (created_at et updated_at)
  public $timestamps = false;

  protected $fillable = [
    'image_path',
    'position',
  ];

  /**
   * @desc Relation one-to-one avec Car : chaque enregistrement d'une image appartient à une seule voiture
   * @return BelongsTo
   */
  public function car(): BelongsTo
  {
    return $this->belongsTo(Car::class);
  }
}
