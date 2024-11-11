## Laracar

### Cours TheCodeholic
https://thecodeholic.com/courses/laravel-11-for-beginners/lectures/55353128

## Etapes

### Controller - Views - Routes
- `HomeController`, method index, route home
- Vue home/`index.blade.php`, import template html
- coller image, css, js dans le dossier public
- Layouts : `AppLayout` et `BaseLayout`
- Component header : components/layouts/`header.blade.php`
- Component search-form : components/`search-form.blade.php`
- Component car-item : components/search-form.blade.php
- Components `LoginController` et `SignupController`, methode create, route login et signup
- Vues auth/`login.blade.php` et auth/`signup.blade.php` : implement template
- Components `google-button.blade.php` et `fb-button.blade.php`
- Component `GuestLayout` et vue `guest.blade.php` pour page login et signup
- Component `CarItem`
- `CarController` resource et Views (car.index, car.show, car.edit, car.create, car.search)
- copier template html dans les 5 fichiers blade correspondants
- créer routes `/car/search` et les 7 routes pour la ressource car
- modifier Links to pages (header.blade, car-item, search-form, login, signup)

### Database
- Database Configuration
- Migrations
- Ajouter colonnes `phone`, `google_id`, `facebook_id` à la table `users` puis migrate:fresh (drop les tables et les créé ensuite)
- Créer tables `car_types`, `fuel_types`, `makers`, `models`, `states`, `cities` 
- Créer tables `cars` et `car_features`
- Créer tables `car_images` et `favourite_cars`
- Générer les models `FuelType`, `CarType`, `Maker`, `Model`, `State`, `City`, `Car`, `CarFeatures`, `CarImages`
- Route Model Binding => `Car $car`
- Désactiver Timestamps sur toutes les tables donc dans tous les models sauf la table `cars`
- Insérer quelques data manuellement en bdd pour pouvoir les lire
- Select Data using Eloquent dans `HomeController` method `index`
- Insert Data using Eloquent
- Insert Data - Using `$fillable`
- Définir `$fillable` sur tous les models
- Define Primary key pour `CarFeatures`
- Update `Cars` Data Basic
- Methode `updateOrCreate([], [])`
- Effectuer update en masse
- Delete `Cars`
- Delete plusieurs cars - Method `destroy()` 
- Method `Car::truncate()` supprime toutes les cars définitivement de la bdd même si `SoftDeletes` dans le model Car
- Renommer le model `CarImages` en `CarImage`

### Relations entre les tables en bdd ORM
- relation one-to-one entre `cars` et `car_features`
- relation one-to-many entre `cars` et `car_images`
- relation one-to-many entre `cars` et `car_types`
- relation many-to-many entre `cars` et `users`
- plusieurs relations BelongsTo ou HasMany (one-to-many) : 
- relation one-to-many entre `cars` et `fuel_types`
- relation one-to-many entre `cars` et `makers`
- relation one-to-many entre `cars` et `models`
- relation one-to-many entre `cars` et `users` (owner)
- relation one-to-many entre `cars` et `cities`
- relation one-to-one entre `car_features` et `cars`
- relation one-to-many entre `car_images` et `cars`
- relation one-to-many entre `cities` et `cars`
- relation one-to-many entre `cities` et `states`
- relation one-to-many entre `fuel_types` et `cars`
- relation one-to-many entre `makers` et `cars`
- relation one-to-many entre `makers` et `models`
- relation one-to-many entre `models` et `cars`
- relation one-to-many entre `models` et `makers`
- relation one-to-many entre `states` et `cars`
- relation one-to-many entre `states` et `cities`
- relation one-to-many entre `users` (owner) et `cars`

### Factories
- Générer une class factory pour chaque model
- générer des données fakes
- Factory Sequences
- Factory States
- Factory Callbacks
- Factory Relationships Maker-Model - One to many : `ModelFactory` `MakerFactory` - utilisation d'une méthode magique `hasModels()` (Models vient de la relation Maker avec Model qui est "models")
- Factory Relationships - Model avec Maker - Belongs To : methode magique `forMaker()` basée sur la relation "maker" dans Model.php
- Créer toutes les factories : `CarTypeFactory`, `FuelTypeFactory`, `StateFactory`, `CityFactory`, `CarFactory`, `CarFeaturesFactory`, `CarImageFactory`
- Factory Relationships - Many to many - User avec Car et relation `favouriteCars()`

### Seeders
- Créer et exécuter Seeders : `UsersSeeder`
- On supprime `UsersSeeder` car on va créer nos data dans DatabaseSeeder
- Créer Seed Data pour le projet dans `DatabaseSeeder`

### Output Data on the Website from the Database
- Render Cars on Home Page
- Retourner les cars dans la home page `index.blade.php`, methode inde du HomeController, index. blade et car-item.blade
- Query Data - Différentes méthodes (présentation dans slides) 
- Render Cars on Search Page
- Retourner le nombre de cars et les cars sélectionnées sur la page de recherche `search.blade;php`
- Data Ordering (présentation dans slides) 
- Output Content on Car Details Page
- Afficher les variables de sorties dans la page de détails `show.blade.php`
- Pour les caractéristiques, créer un component `car-specification`
- Output Content on My Cars Page
- afficher le contenu de la page My Cars, `car/index.blade.php`
- Implement Watchlist Page = Page My favourite Cars
- créer la vue `watchlist.blade.php`
- initier methode `watchlist` dans CarController
- définir la route `GET /car/watchlist`

### Eager Loading
- les performances sont dégradées quand on select des cars avec de multiples relations city(), carType() ...
- methode with() pour remedier à ce pb connu. Les requêtes SQL sont bien moins nombreuses
- Eager Loading on Home Page
Exemple: 
```php
with(['primaryImage', 'city', 'model', 'maker', 'carType', 'fuelType' ])
```
- Eager Loading on Other Pages (search, watchlist et mycars)
- mettre à jour avec le eager loading les méthodes `search`, `watchlist` et `index` de `CarController`
- Database Jointures
Exemple : trier les cars par state (methode `search`)
```php
$query = Car::where('published_at', '<', now())
      ->with(['primaryImage', 'city', 'model', 'maker', 'carType', 'fuelType' ])
      ->orderby('published_at', 'desc');

$query->join('cities', 'cities.id', '=', 'cars.city_id')
  ->where('cities.state_id', 1);
```
ou
```php
$query->select('cars.*', 'cities.name as city_name');
dd($cars[0])
```
### Where Clause
- présentation de la clause Where dans slides
- basic where clause
- additionnal where clause
- multiple where using grouping
- where exists clause
- subquery where clause
- query debugging

### PData agination
- pagination implémenter dans `CarController` methode `search` et dans page `search.blade`
- Plusieurs façons de personnaliser la pagination
- Par exemple pour récupérer les différentes pagination bootstrap, tailwind etc
```bash
php artisan vendor:publish --tag=laravel-pagination
```
- on ne garde pas le dossier "vendor" car on va créer notre propre vue pour la pagination
- créer la vue `pagination.blade`
- ajouter la pagination sur les pages `search.blade`, `watchlist.blade` et `car/index.blade`
- il existe aussi la single pagination `singlePaginate(15)` qui montre que "previous" et "next" et on ne peut pas utiliser dans la page la fonction `total()` qui permet de récupérer le total d'enregistrements
- Customize Pagination URLs
- méthodes pour personnaliser les URLS
- exemple : `withPath('/user/cars)`, `appends(['sort' => 'price'])` ajoute queryParams `?sort=price`, `withQueryString()` pour préserver les query params quand on change de page et `fragment('cars')` génère un lien avec `#` `localhost:8000/car?page=3#cars`

### Request & Response
- Accessing the Request
- accèder aux data de la requête avec `Request` de Illuminate/HTTP ou la fonction globale `request()`
- Creating Response
- exemples de response
- Redirect
Exemple : 
- `redirect('/car/create')`, `redirect()->route('car.create')`, `redirect()->route('car.show', ['car' => 1])`, `redirect()->route('car.show', Car::first())`
- pour rediriger en dehors du site : `redirect()->away('https://google.com')`

### Searching for Cars + Code Refactoring
- Créer des components séparés pour Selects Maker et Model 
- Components Dropdown pour State, City
- Components Dropdown pour CarType, FuelType
- Re-use Components on Search Page
- Access Request Data
- Implement Car Search
- Populate Search form with Request Data
- Show Text When no Cars are Found
- Implement Sorting Cars p241 

### Create new car, Features and Images
- Implement Form Submission with @csrf directive
- Disable CSRF Validation
- Prepare Car Create Form for Submission p248
- Create New Car
- Create Car Features
- Fix bug when car without image was not rendering
- Don't show car details page for non published car
- Create Car Images p256
- Modifier `config/filesystems.php` pour enlever dans 'local' "private" sur "app/private" sinon un dossier "private" va se créer automatiquement
```php
'local' => [
    'driver' => 'local',
    'root' => storage_path('app'),
    'serve' => true,
    'throw' => false,
],
```

### Data Validation
- Introduction to validation
- Writing Validation Logic in `CarController`, method `store`
- Available Validation Rules
- Handle Validation Errors
- Validation With Bags quand plusieurs formulaires sur une même page
- Repopulating Forms 
- Manually Creating Validators
- Customize Validation Messages
- Conditional Validation
- Validating Arrays
- Validating Files
- Custom Validation Rules
- Project - Implement All Validation Rules 

### Form Request Validation
- Form Request Validation : création de `StoreCarRequest`
- Customize Validation messages and Attributes : methodes `messages()` et `attributes()`
- Customize Form Request Class : `protected $stopOnFirstFailure = true;` `protected $redirect = '/';` ou `protected $redirectRoute = 'car.index';`
- Working with Validated Input
- Display Error Messages for Images

### Finish Car CRUD
- Render Car Update Form
- Update Car Details
- Delete Car
- Display Car Images
- Update Car Image
- Deleting Images, Change Image Positions 
- Show Add More Images Form
- Add More Images to Car

### Sessions
- Introduction to Sessions
- Working with Session Data
- Session Flash Data

### Authentication
- Signup 
- Le password doit contenir au moins 8 caractères, au plus 24 caractères, au moins 1 nombre, au moins une minuscule et une majuscule et un symbole.
- Validating Passwords
- Implement Login
- Logout
- Password Reset
- Use Authenticated User ID

### Middlewares
- Introduction to middlewares p333
- Create Basic middleware
- Grouping routes by middleware
- Excluding Middlewares
- Explore Core Middlewares
- Middleware Aliases
- Controller Middlewares
- Email Verification

