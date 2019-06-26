<?php

/**
 *
 * Orchestra Testbench provides extra laravel functionality
 * such as load migrations etc. Read more here:
 * https://github.com/orchestral/testbench
 *
 * @author Daniel Leppänen
 */
namespace Halpdesk\LaravelMinimumPackage\Tests;

use Absolute\DotEnvManipulator\Libs\DotEnv;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Support\Facades\Config;
use Halpdesk\LaravelMinimumPackage\Seeders\DatabaseSeeder;
use Halpdesk\LaravelMinimumPackage\Models\Payment;

class TestCase extends OrchestraTestCase
{
    /**
     * @param String    The full path to the root of this project
     */
    protected static $dir;

    /**
     * Setup the test environment
     */
    protected function setUp() : void
    {
        parent::setUp();
        $this->initialize();
        $this->loadEnvironment();

        config([
            'stripe' => [
                'classes' => [
                    'payment'  => Payment::class,
                ],
            ],
        ]);

        $this->loadMigrationsFrom([
            '--database' => env('DB_CONNECTION', 'testing'),
            '--path' => static::$dir . '/database/migrations',
        ]);
        $this->withFactories(static::$dir . '/database/factories');

        // $this->artisan('db:seed', ['--class' => DatabaseSeeder::class]);
    }

    public static function setUpBeforeClass()
    {
        static::$dir = realpath(dirname(realpath(__FILE__)).'/../');
        parent::setUpBeforeClass();
    }

    /**
     * Load package service providers
     * ex. ['Acme\AcmeServiceProvider']
     *
     * @return void
     */
    protected function getPackageProviders($app)
    {
        $parentPackageProviders = parent::getPackageProviders($app);

        $providers = array_merge($parentPackageProviders, [
            \Halpdesk\LaravelMinimumPackage\LaravelServiceProvider::class,
        ]);

        return $providers;
    }

    /**
     * Load package alias if needed
     * ex. ['Acme' => 'Acme\Facade']
     *
     * @return void
     */
    protected function getPackageAliases($app)
    {
        $parentPackageAliases = parent::getPackageAliases($app);

        // Don't create aliases for tests: it makes them harder to read / Halpdesk
        $aliases = array_merge($parentPackageAliases, [

        ]);

        return $aliases;
    }

    /**
     * This is usually loaded/bootstrapped from phpunit.xml otherwise
     *
     * @return void
     */
    public static function composerAutoLoader()
    {
        require_once static::$dir . 'vendor/autoload.php';
    }

    /**
     * Initialize environment
     * Set ini parameters here, for example
     *
     * @return void
     */
    public function initialize()
    {
        date_default_timezone_set('Europe/Stockholm');
    }

    /**
     * Load environment from .env file and write all environment
     * variables. Works well with laravels env() helper function
     *
     * @return void
     */
    public function loadEnvironment()
    {
        // $dotenv = new DotEnv(static::$dir, '.env');
        // $envs = $dotenv->toArray();
        // foreach ($envs as $env => $value) {
        //     putenv($env.'='.$value);
        // }

        $configFiles = glob(static::$dir.'config/*.php');
        foreach ($configFiles as $key => $configFile) {
            $name   = str_replace(".php", "", basename($configFile));
            $config = require $configFile;
            $existingConfig = Config::get($name, []);
            Config::set($name, array_replace_recursive($existingConfig, $config));
        }
    }
}
