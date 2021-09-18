## How To Install

`composer require klc/translation`

`php artisan migrate`



## How To Use

#### Get translation :

```php
/*
*first parameter id translation slug
*second parameter is language_id
*/

\KLC\Translation::translate('hello_world', 3);
```

#### Get translation with dynamic parameter :

```php
/*
*Translation is "Hello %s"
*first parameter id translation slug
*second parameter is language_id
*third parameter is translation parameter
*/

\KLC\Translation::translate('hello', 2, ['World']);
\KLC\Translation::translate('hello', 2, ['John']);
```



#### Clear translation cache :

```php
/*
*first parameter is language_id
*/

\KLC\Translation::cacheClear(1);
```

