# admin-page

### Информация

Страничный модуль заточенный для CMS IRsite.

### Установка

```
$ composer require avl/admin-page
```
Или в секцию **require** добавить строчку *"avl/admin-page": "^1.0"*.

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
