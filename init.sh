touch database/database.sqlite
cp .env.example .env
composer install
php artisan key:generate
npm install
npm run build
php artisan migrate:fresh
php artisan db:seed
php artisan storage:link
