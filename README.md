# admin-page

### Информация

Новостной модуль заточенный для CMS IRsite.

### Установка

```
$ composer require avl/admin-page
```

```json
{
    "require": {
        "avl/admin-page": "^1.0"
    }
}
```
### Настройка

Для публикации опубликации файла настроек необходимо выполнить команду:

```
$ php artisan vendor:publish --provider="Avl\AdminPage\AdminPageServiceProvider" --force
```