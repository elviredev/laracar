## Laracar

### Youtube
- Temps : 8:40:51
- https://www.youtube.com/watch?v=0M84Nk7iWkA&t=1598s

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
- CarController resource et Views (car.index, car.show, car.edit, car.create, car.search)
- copier template html dans les 5 fichiers blade correspondants
- créer routes /car/search et les 7 routes pour la ressource car
- modifier Links to pages (header.blade, car-item, search-form, login, signup)

### Database
- Database Configuration
- Migrations
- Ajouter colonnes `phone`, `google_id`, `facebook_id` à la table `users` puis migrate:fresh (drop les tables et les créé ensuite)
- Créer tables `car_types`, `fuel_types`, `makers`, `models`, `states`, `cities` 
- Créer tables `cars` et `car_features`
- Créer tables `car_images` et `favourite_cars`
- Générer les models `FuelType`, `CarType`, `Maker`, `Model`, `State`, `City`, `Car`, `CarFeatures`, `CarImages`
- Route Model Binding => Car $car
- Désactiver Timestamps sur toutes les tables donc dans tous les models sauf la table `cars`
- Insérer quelques data manuellement en bdd pour pouvoir les lire
- Select Data using Eloquent dans HomeController method `index`
- Insert Data using Eloquent
- Insert Data - Using $fillable
- Définir $fillable sur tous les models
- Define Primary key pour CarFeatures
- Update Data Basic
- Methode `updateOrCreate([], [])`
- Effectuer update en masse
- Delete Car
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

### Render Cars on Home Page
- Retourner les cars dans la home page `index.blade.php`, methode inde du HomeController, index. blade et car-item.blade
- Query Data - Différentes méthodes (présentation dans slides) 

### Render Cars on Search Page
- Retourner le nombre de cars et les cars sélectionnées sur la page de recherche `search.blade;php`
- Data Ordering (présentation dans slides) 

### Output Content on Car Details Page
- Afficher les variables de sorties dans la page de détails `show.blade.php`
- Pour les caractéristiques, créer un component `car-specification`

### Output Content on My Cars Page
- afficher le contenu de la page My Cars, `car/index.blade.php`

### Watchlist Page = Page My favourite Cars
- créer la vue `watchlist.blade.php`
- initier methode `watchlist` dans CarController
- définir la route `GET /car/watchlist`

### Eager Loading
- les performances sont dégradées quand on select des cars avec de multiples relations city(), carType() ...
- methode with() pour remedier à ce pb connu. Les requêtes SQL sont bien moins nombreuses

### Eager Loading on Home Page
->with(['primaryImage', 'city', 'model', 'maker', 'carType', 'fuelType' ])

### Eager Loading on Other Pages (search, watchlist et mycars)
- mettre à jour avec le eager loading les méthodes `search`, `watchlist` et `index` de `CarController`

### Database Jointures
9:44:33



