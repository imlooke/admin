# imlooke-admin

Admin dashboard build with `Laravel & React`.

## COMMAND

```bash
php artisan migrate --path=packages\imlooke\admin\database\migrations
php artisan migrate:rollback --path=packages\imlooke\admin\database\migrations
php artisan vendor:publish --provider="Imlooke\Admin\AdminServiceProvider"
php artisan admin:install
php artisan admin:uninstall
php artisan admin:assets-link
```

## TODO LIST

- [ ] permissions & menus data
- [ ] menus
- [ ] settings
- [ ] clear cache
- [ ] filesystem
