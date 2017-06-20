Illuminate Database Provider
============================

Provides [Illuminate Database](https://github.com/illuminate/database/)
connections as services to Pimple applications.


Usage
-----

First you will have to create [Pimple](https://github.com/silexphp/Pimple) container
or [Silex](https://github.com/silexphp/Silex) application.

```php
// Creating new Silex application
$app = new Silex\Application();

```

Then you `register` the `IlluminateDatabaseServiceProvider` to your container or application.

```php
use Rikniitt\Provider\IlluminateDatabase\IlluminateDatabaseServiceProvider;

// Register database provider with MySQL connection and setup Eloquent ORM.
$app->register(new IlluminateDatabaseServiceProvider(), [
    'database.settings.connections' => [
        'default' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'database',
            'username'  => 'root',
            'password'  => 'password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],
    'database.settings.global' => false,
    'database.settings.eloquent' => true,
]);
```

After registering service provider, the database connection is accesible via **database**.

```php
// Simple active users query.
$users = $app['database']->select('SELECT * FROM users WHERE active = ?', [1]);
```


Configuration
-------------

 * **database.settings.connections**:
   Array of database connections where the key is name for the connection and it's value
   is array of connection options. Laravel framework contains default
   [database configurationfile](https://github.com/laravel/laravel/blob/master/config/database.php)
   with multiple examples of different database driver options.
 * **database.settings.global**:
   Boolean value indicating if the `Illuminate\Database\Capsule\Manager` instance created by `IlluminateDatabaseServiceProvider`
   should be made `global`.
 * **database.settings.eloquent**:
   Boolean value indicating if the [Eloquent ORM](https://laravel.com/docs/5.2/eloquent) should be set up.


Services
--------

 * **database**:
   Alias for **database.connection**.
 * **database.connection**:
   Default database connection, instance of [Illuminate\Database\Connection](https://github.com/illuminate/database/blob/master/Connection.php).
   It provides all the basic methods to access and manipulate the database: `select`, `insert`, `update` ... See the Laravel
   [database documentation](https://laravel.com/docs/5.2/database) for more details. Note that **database.connection** provides as instance
   methods most of the static methods of Laravel `DB Facade`.
 * **database.schema**:
   Default database connection schema builder, instance of
   [Illuminate\Database\Schema\Builder](https://github.com/illuminate/database/blob/master/Schema/Builder.php).
   It provides methods for defining and altering the database schema: `create`, `drop`, `hasColumn` ... See the Laravel
   [migrations documentation](https://laravel.com/docs/5.2/migrations) for more details.
 * **database.manager**:
   Instance of Illuminate database manager, which was created by `IlluminateDatabaseServiceProvider`, instance of
   [Illuminate\Database\Capsule\Manager](https://github.com/illuminate/database/blob/master/Capsule/Manager.php).
   It provides methods to access all the connections, not only the default.
