<?php

namespace City\Script;

use \Exception;
use \InvalidArgumentException;

// Dependencies from PSR-7 (HTTP Messaging)
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

// Dependency from 'charcoal-app'
use \Charcoal\App\Script\AbstractScript;

// Database dependencies
use \PDO;
use Psr\Log\NullLogger;

/**
 * Config the current project
 *
 * The current script will alter the project's files
 * to to the configuration is done for the user.
 */
class ConfigScript extends AbstractScript
{
    use KeyNormalizerTrait;
    /**
     * @var string $dbName The database name.
     */
    protected $dbName;

    /**
     * @var string $dbUser The database user.
     */
    protected $dbUser;

    /**
     * @var string $dbPassword The database password.
     */
    protected $dbPassword;

    /**
     * @var string $dbHost The database host.
     */
    protected $dbHost;

    /**
     * @var string $defaultDbUser The default database user.
     */
    protected $defaultDbUser = 'root';

    /**
     * @var string $defaultDbPassword The default database password.
     */
    protected $defaultDbPassword = '';

    /**
     * @var string $defaultDbHost The default database hostname.
     */
    protected $defaultDbHost = '127.0.0.1';

    /**
     * @var string $sqlPath The path to the sql file to install.
     */
    protected $sqlPath = 'build/loco_city.sql';

    /**
     * @var string $rootPath The project root path.
     */
    protected $rootPath = __DIR__.'/../../../';

    /**
     * @var string $env The APPLICATION_ENV.
     */
    protected $env;

    // ==========================================================================
    // DEFAULTS
    // ==========================================================================

    /**
     * Retrieve the available default arguments of this action.
     *
     * @link http://climate.thephpleague.com/arguments/ For descriptions of the options for CLImate.
     *
     * @return array
     */
    public function defaultArguments()
    {
        $arguments = [
            'databaseName'     => [
                'prefix'      => 'n',
                'longPrefix'  => 'name',
                'description' => 'Database name.'
            ],
            'databaseUser'     => [
                'prefix'      => 'u',
                'longPrefix'  => 'user',
                'description' => 'Database user name'
            ],
            'databasePassword' => [
                'prefix'      => 'p',
                'longPrefix'  => 'password',
                'description' => 'Database password'
            ],
            'databaseHost'     => [
                'prefix'      => 'h',
                'longPrefix'  => 'host',
                'description' => 'Database host name'
            ]
        ];

        $arguments = array_merge(parent::defaultArguments(), $arguments);

        return $arguments;
    }

    // ==========================================================================
    // INIT
    // ==========================================================================

    /**
     * @param array|\ArrayAccess $data The dependencies (app and logger).
     */
    public function __construct($data = null)
    {
        if (!isset($data['logger'])) {
            $data['logger'] = new NullLogger();
        }

        parent::__construct($data);

        $arguments = $this->defaultArguments();
        $this->setArguments($arguments);
    }

    /**
     * Create a new rename script and runs it while passing arguments.
     * @param array $data The data passed.
     * @return void
     */
    public static function start(array $data = [])
    {
        $script = new ConfigScript();

        // Parse data
        foreach ($data as $key => $value) {
            $setter = $script->camel('set-'.$key);
            if (is_callable($script, $setter)) {
                $script->{$setter}($value);
            } else {
                $script->climate()->to('error')->red(sprintf(
                    'the setter "%s" was passed to the start function but doesn\'t exist!',
                    $setter
                ));
            }
        }
        $script->config();
    }

    /**
     * @see \League\CLImate\CLImate Used by `CliActionTrait`
     * @param RequestInterface  $request  PSR-7 request.
     * @param ResponseInterface $response PSR-7 response.
     * @return void
     */
    public function run(RequestInterface $request, ResponseInterface $response)
    {
        // Never Used
        unset($request, $response);
        $this->config();
    }

    // ==========================================================================
    // FUNCTIONS
    // ==========================================================================

    /**
     * Interactively setup a Charcoal module.
     *
     * The action will ask the user a series of questions,
     * and then update the current module for them.
     *
     * It attempts to config the project including :
     * - Checking for env var or create it
     * - Create a config.json file
     * - Setting the database and renaming it
     * - Adjust some database data
     * @return void
     * @throws CancelledScriptException When the user skip the database creation.
     */
    private function config()
    {
        $climate = $this->climate();

        $climate->underline()->green()->out('Charcoal city config script');

        // If the user asked for help, give it.
        if ($climate->arguments->defined('help')) {
            $climate->usage();
            return;
        }

        // Parse the received arguments
        $climate->arguments->parse();

        // Verbose
        $verbose    = !!$climate->arguments->get('quiet');
        $this->setVerbose($verbose);

        // Detect the APPLICATION ENVIRONMENT var.
        $env = $this->getEnv();
        $climate->out(sprintf(
            'The APPLICATION ENVIRONMENT is "%s"',
            $env
        ));

        // Database creation
        $this->createDb();

        // Create the config.env.json file.
        $this->createConfigFile();

        // Modify database data
        // @todo Update datas to stay up to date.
        $this->updateDatabaseData();

        // GG
        $climate->green()->out("\n".'The project was configured with Success!');
    }

    /**
     * Creates the database for the user using
     * the supplied sql database (loco_city.sql).
     *
     * @return void
     */
    private function createDb()
    {
        $climate = $this->climate();

        // Should be set, at this point.
        $dbName     = $this->dbName();
        $dbUser     = $this->dbUser();
        $dbPassword = $this->dbPassword();
        $dbHost     = $this->dbHost();

        // Output database creation data
        $climate->out('Creating database using :');
        $climate->table([
            [
                'Name'     => '<green>'.$dbName.'</green>',
                'User'     => '<green>'.$dbUser.'</green>',
                'Password' => '<green>'.$dbPassword.'</green>',
                'Hostname' => '<green>'.$dbHost.'</green>',
            ]
        ]);

        // Set UTf-8 compatibility by default.
        $extraOptions = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];

        $dsn = 'mysql:host='.$dbHost;
        $db  = new PDO($dsn, $dbUser, $dbPassword, $extraOptions);

        // Set PDO options
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        $q = "SELECT COUNT(*)
              FROM INFORMATION_SCHEMA.SCHEMATA
              WHERE SCHEMA_NAME = '".$dbName."'";

        $dbExist = $db->query($q);

        if (!$dbExist->fetchColumn()) {
            $climate->out('database does not exist...');
            $climate->out('creating database...');

            $q = 'CREATE DATABASE IF NOT EXISTS `'.$dbName.'`';
            $db->query($q);
        }

        $q = 'USE `'.$dbName.'`';
        $db->query($q);

        $q = file_get_contents($this->rootPath.$this->sqlPath);
        $db->query($q);

        $climate->green()->out(sprintf(
            'The database %s was successfully created!',
            $dbName
        ));
    }

    /**
     * Create the local config file.
     * @return void
     */
    private function createConfigFile()
    {
        $climate     = $this->climate();
        $configLocal = 'config/config.'.$this->env.'.json';

        $configSamplePath = $this->rootPath.'config/config.sample.json';
        $configLocalPath  = $this->rootPath.$configLocal;

        $climate->out(sprintf(
            'Creating %s...',
            $configLocal
        ));

        copy(
            $configSamplePath,
            $configLocalPath
        );

        $jsonString = file_get_contents($configLocalPath);
        $data       = json_decode($jsonString, true);

        // Replace config data with user data
        $data['databases']['default']['database'] = $this->dbName();
        $data['databases']['default']['username'] = $this->dbUser();
        $data['databases']['default']['password'] = $this->dbPassword();
        $data['databases']['default']['hostname'] = $this->dbHost();

        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($configLocalPath, $newJsonString);

        $this->climate()->green()->out(sprintf(
            'The %s file was created and updated to match your config!',
            $configLocal
        ));
    }

    /**
     * Update the database with data that match current dates.
     * @todo Update the database with dates based on today().
     * @return void
     */
    private function updateDatabaseData()
    {
    }


    // ==========================================================================
    // SETTERS
    // ==========================================================================


    // ==========================================================================
    // GETTERS
    // ==========================================================================

    /**
     * Retrieve the database name.
     *
     * @return string
     */
    public function dbName()
    {
        if ($this->dbName) {
            return $this->dbName;
        }

        // Information provided as argument
        $dbName = $this->climate()->arguments->get('databaseName');
        if ($this->isValidDbName($dbName)) {
            $this->dbName = $dbName;
            return $this->dbHost;
        }

        $input  = $this->climate()->input(
            'Database <red>name</red> (<red>Database will be created or overwritten, '.
            'let blank to use another database</red>) :'
        );

        $that = $this;
        $input->accept(function ($response) use ($that) {
            // Validate the output
            return $that->isValidDbName($response);
        });

        $this->dbName = $input->prompt();
        return $this->dbName;
    }

    /**
     * Retrieve the database user name.
     *
     * @return string
     */
    public function dbUser()
    {
        if ($this->dbUser) {
            return $this->dbUser;
        }

        // Information provided as argument
        $dbUser = $this->climate()->arguments->get('databaseUser');
        if ($this->isValidDbUser($dbUser)) {
            $this->dbUser = $dbUser;
            return $this->dbUser;
        }

        $input = $this->climate()->input(sprintf(
            'Database <red>username</red> : [default: <green>%s</green>]',
            $this->defaultDbUser
        ));
        $input->defaultTo($this->defaultDbUser);

        $that = $this;
        $input->accept(function ($response) use ($that) {
            // Use default to.
            if (!$response) {
                return true;
            }
            // Validate the output
            return $that->isValidDbUser($response);
        });

        $this->dbUser = $input->prompt();
        return $this->dbUser;
    }

    /**
     * Retrieve the database password.
     *
     * @return string
     */
    public function dbPassword()
    {
        // Allows empty string password
        if ($this->dbPassword !== null) {
            return $this->dbPassword;
        }

        // Information provided as argument
        $password = $this->climate()->arguments->get('databasePassword');
        if ($this->isValidDbPassword($password)) {
            $this->dbPassword = $password;
            return $this->dbPassword;
        }

        $input = $this->climate()->input(sprintf(
            'Database <red>password</red> : [default: <green>%s</green>]',
            $this->defaultDbPassword
        ));
        $input->defaultTo($this->defaultDbPassword);

        $that = $this;
        $input->accept(function ($response) use ($that) {
            // Use default to.
            if (!$response) {
                return true;
            }
            // Validate the output
            return $that->isValidDbPassword($response);
        });

        $this->dbPassword = $input->prompt();
        return $this->dbPassword;
    }

    /**
     * Retrieve the database host.
     *
     * @return string
     */
    public function dbHost()
    {
        // Don't go twice there
        if ($this->dbHost) {
            return $this->dbHost;
        }

        // Information provided as argument
        $host = $this->climate()->arguments->get('databaseHost');
        if ($this->isValidDbHost($host)) {
            $this->dbHost = $host;
            return $this->dbHost;
        }

        // Ask for the information
        $input = $this->climate()->input(sprintf(
            'Database <red>hostname</red> : [default: <green>%s</green>]',
            $this->defaultDbHost
        ));

        $that = $this;
        $input->accept(function ($response) use ($that) {
            // Use default to.
            if (!$response) {
                return true;
            }
            // Validate the output
            return $that->isValidDbHost($response);
        });
        $input->defaultTo($this->defaultDbHost);

        // Validates the prompt input.
        $this->dbHost = $input->prompt();
        return $this->dbHost;
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        $env = getenv('APPLICATION_ENV');

        if (!$env) {
            putenv('APPLICATION_ENV=local');
            $env = 'local';
        }

        $this->env = $env;

        return $env;
    }


    // ==========================================================================
    // UTILS
    // ==========================================================================

    /**
     * Check if the database name is valid.
     * @param  string $dbName Database name.
     * @return boolean        Database name is valid or not.
     */
    private function isValidDbName($dbName)
    {
        // Null || empty || false
        if (!$dbName) {
            return false;
        }

        // Not a string
        if (!is_string($dbName)) {
            return false;
        }

        // Invalid string
        if (!preg_match('/^[-a-z_0-9]+$/i', $dbName)) {
            return false;
        }

        return true;
    }

    /**
     * Check if the database user name is valid.
     * @param  string $dbUser Database user.
     * @return boolean        Database user is valid or not.
     */
    private function isValidDbUser($dbUser)
    {
        // Null || empty || false
        if (!$dbUser) {
            return false;
        }

        // Not a string
        if (!is_string($dbUser)) {
            return false;
        }

        // Invalid string
        if (!preg_match('/^[-a-z_ ]+$/i', $dbUser)) {
            return false;
        }

        return true;
    }

    /**
     * Check if the database password is valid.
     * Allows empty string password.
     * @param  string $dbPassword Database password.
     * @return boolean            Database password is valid or not.
     */
    private function isValidDbPassword($dbPassword)
    {
        if ($dbPassword === null) {
            return false;
        }

        if (!is_string($dbPassword)) {
            return false;
        }
        return true;
    }

    /**
     * Check if the database user host is valid.
     * @param  string $dbHost Database host.
     * @return boolean        Database host is valid or not.
     */
    public function isValidDbHost($dbHost)
    {
        if (!is_string($dbHost)) {
            return false;
        }

        if (!$dbHost) {
            return false;
        }

        return true;
    }


}
