## Laracar

### Youtube
- Temps : 6:44:46
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
- Relations entre les tables en bdd ORM
- relation one-to-one entre `cars` et `car_features`
- relation one-to-many entre `cars` et `car_images`
- relation many-to-many entre `cars` et `users`
