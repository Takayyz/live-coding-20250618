php -v
exit
priintenv
echo ${DB_HOST}
ls -la
vi .env
vim  .env
exit
php artisan migrate
php artisan migrate:rollback
php artisan migrate
exit
