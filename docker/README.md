1/ Configuration

```
composer install
npm install
php artisan key:generate
php artisan migrate
npm run dev
php artisan queue:listen
php artisan passport:install
```
1.1/ Factory
```
php artisan db:seedb --class=UserSeeder

php artisan tinker;
UserRole::factory()->count(10)->create();
IssueType::factory()->count(10)->create();
```

2/ Unit testing

```
Migrate:
php artisan migrate --env=testing

Run test:
php artisan test --env=testing
php artisan test tests/Unit/Http/Controllers/IssueControllerTest.php --env=testing

Init coverage file:
php artisan test --coverage-html {folder}
```
