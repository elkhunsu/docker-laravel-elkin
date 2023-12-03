php artisan db:wipe --force

php artisan config:clear
php artisan route:clear
php artisan event:clear
php artisan view:clear

composer install

php artisan migrate

php artisan db:seed --class=UsersTableSeeder --force
php artisan db:seed --class=CurrenciesTableSeeder --force

