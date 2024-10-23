<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin IdeHelperCarFeatures
 */
class CarFeatures extends Model
{
  use HasFactory;

  // Désactiver les colonnes timestamps (created_at et updated_at)
  public $timestamps = false;

  protected $primaryKey = 'car_id';

  protected $fillable = [
    'car_id',
    'abs',
    'air_conditionning',
    'power_windows',
    'power_door_locks',
    'cruise_control',
    'bluetooth_connectivity',
    'remote_start',
    'gps_navigation',
    'heated_seats',
    'climate_control',
    'rear_parking_sensors',
    'leather_seats'
  ];
}
