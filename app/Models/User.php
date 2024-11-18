<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements MustVerifyEmail
{
  /** @use HasFactory<UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'phone',
    'google_id',
    'facebook_id',
    'password',
    'email_verified_at'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
  }

  /**
   * @desc Relation many-to-many avec Car sur la table pivot 'favourite_cars'
   * Un utilisateur peut marquer plusieurs voitures comme favorites.
   * @return BelongsToMany
   */
  public function favouriteCars(): BelongsToMany
  {
    return $this->belongsToMany(Car::class, 'favourite_cars');
  }

  /**
   * @desc Relation one-to-many avec Cars : Un user (owner) peut posséder plusieurs voitures
   * @return HasMany
   */
  public function cars():HasMany
  {
    return $this->hasMany(Car::class);
  }

  /**
   * @desc Permet d'identifier les users authentifiés avec Google ou Facebook qui n'ont pas
   * de mdp défini en bdd donc ils ne pourront pas modifier leur email sur leur page de profil
   * @return bool
   */
  public function isOauthUser (): bool
  {
    return !$this->password;
  }
}
