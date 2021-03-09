```
php artisan migrate --path=packages\imlooke\admin\database\migrations
php artisan migrate:rollback --path=packages\imlooke\admin\database\migrations
php artisan vendor:publish --provider="Imlooke\Admin\AdminServiceProvider"
php artisan admin:install
php artisan admin:uninstall
php artisan admin:assets-link
```
