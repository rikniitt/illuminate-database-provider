<?php

namespace Rikniitt\Provider\IlluminateDatabase;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Illuminate\Database\Capsule\Manager as DB;

class IlluminateDatabaseServiceProvider implements ServiceProviderInterface
{

    /**
     * Register Database service.
     *
     * @param Pimple\Container $pimple
     */
    public function register(Container $pimple)
    {
        $defaults = [
            'database.settings.connections' => [],
            'database.settings.global' => false,
            'database.settings.eloquent' => false,
        ];

        $pimple['database.manager'] = function () use ($pimple, $defaults) {

            foreach ($defaults as $key => $value) {
                if (!isset($pimple[$key])) {
                    $pimple[$key] = $value;
                }
            }

            $database = new DB();

            foreach ($pimple['database.settings.connections'] as $name => $connection) {
                $database->addConnection($connection, $name);
            }

            if ($pimple['database.settings.global']) {
                $database->setAsGlobal();
            }

            if ($pimple['database.settings.eloquent']) {
                $database->bootEloquent();
            }

            return $database;
        };

        $pimple['database.connection'] = function () use ($pimple) {
            $manager = $pimple['database.manager'];
            return $manager->getConnection();
        };
        $pimple['database'] = function () use ($pimple) {
            return $pimple['database.connection'];
        };

        $pimple['database.schema'] = function () use ($pimple) {
            return $pimple['database.connection']->getSchemaBuilder();
        };

    }

}
