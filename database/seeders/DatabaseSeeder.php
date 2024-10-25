<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\State;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // Créer des types de voitures avec les données suivantes à l'aide factories
    // ['Sedan','Hatchback','SUV','Pickup Truck','Minivan','Jeep','Coupe','Crossover','Sports Car']

    CarType::factory()
      ->sequence(
        ['name' => 'Sedan'],
        ['name' => 'Hatchback'],
        ['name' => 'SUV'],
        ['name' => 'Pickup Truck'],
        ['name' => 'Minivan'],
        ['name' => 'Jeep'],
        ['name' => 'Coupe'],
        ['name' => 'Crossover'],
        ['name' => 'Sports Car']
      )
      ->count(9)
      ->create();

    // Créer Fuel types
    // ['Gasoline', 'Diesel', 'Electric', 'Hybrid']
    FuelType::factory()
      ->sequence(
        ['name' => 'Gasoline'],
        ['name' => 'Diesel'],
        ['name' => 'Electric'],
        ['name' => 'Hybrid'],
      )
      ->count(4)
      ->create();

    // Créer States with cities
    $states = [
      'California' => ['Los Angeles', 'San Francisco', 'San Diego', 'San Jose', 'Sacramento'],
      'Texas' => ['Houston', 'San Antonio', 'Dallas', 'Austin', 'Fort Worth'],
      'Florida' => ['Miami', 'Orlando', 'Tampa', 'Jacksonville', 'St. Peters'],
      'New York' => ['New York City', 'Buffalo', 'Rochester', 'Yonkers', 'Syracuse'],
      'Illinois' => ['Chicago', 'Aurora', 'Naperville', 'Joliet', 'Rockford'],
      'Pennsylvania' => ['Philadelphia', 'Pittsburg', 'Allentown', 'Erie', 'Lancaster'],
      'Ohio' => ['Columbus', 'Cleveland', 'Cincinnati', 'Toledo', 'Akron'],
      'Georgia' => ['Atlanta', 'Augusta', 'Columbus', 'Savannah', 'Athens'],
      'North Carolina' => ['Charlotte', 'Raleigh', 'Greensboro', 'Durham', 'Gastonia'],
      'Michigan' => ['Detroit', 'Grand Rapids', 'Warren', 'Sterling Heights', 'Owosso']
    ];

    foreach ($states as $state => $cities) {
      State::factory()
        ->state(['name' => $state])
        ->has(
          City::factory()
          ->count(count($cities))
          ->sequence(...array_map(fn($city) => ['name' => $city], $cities))
        )
        ->create();
    }

    // Créer makers with their corresponding models
    $makers = [
      'Toyota' => ['Camry', 'Corolla', 'Highlander', 'RAV4', 'Prius', 'Yaris', '4Runner'],
      'Ford' => ['F-150', 'Escape', 'Explorer', 'Mustang', 'Fusion', 'Ranger', 'Maverick'],
      'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Odyssey', 'HR-V', 'Ridgeline'],
      'Chevrolet' => ['Silverado', 'Equinox', 'Malibu', 'Impala', 'Cruze', 'El Camino', 'Trailblazer'],
      'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Maxima', 'Murano', 'Pathfinder', 'Qashqai', 'Patrol'],
      'Lexus' => ['RX400', 'RX450', 'RX350', 'ES350', 'LS500', 'IS300', 'GX450']
    ];

    foreach ($makers as $maker => $models) {
      Maker::factory()
        ->state(['name' => $maker])
        ->has(
          Model::factory()
          ->count(count($models))
          ->sequence(...array_map(fn($model) => ['name' => $model], $models))
        )
        ->create();
    }

    // Créer users, cars avec images et features
    // Créer 3 users puis créer 2 users en plus
    User::factory()
      ->count(3)
      ->create();

    // et pour les 2 derniers users, créer 50 cars
    // avec images et features et ajouter ces cars aux favourite cars de ces 2 users
    User::factory()
      ->count(2)
      ->has(
        Car::factory()
          ->count(50)
          ->has(
            CarImage::factory()
            ->count(5)
            ->sequence(fn(Sequence $sequence) =>
            ['position' => $sequence->index % 5 + 1]),
//            ->sequence(
//              ['position' => 1],
//              ['position' => 2],
//              ['position' => 3],
//              ['position' => 4],
//              ['position' => 5]
//              ),
            'images'
          )
        ->hasFeatures(),
        'favouriteCars'
      )
      ->create();
  }
}
