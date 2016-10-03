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
     * RenameScript constructor Register the action's arguments..
     */
    public function __construct()
    {
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
     */
    private function config()
    {
        $climate = $this->climate();

        $climate->underline()->green()->out('Charcoal city config script');

        if ($climate->arguments->defined('help')) {
            $climate->usage();

            return;
        }

        // Parse the received arguments
        $climate->arguments->parse();
        $dbName     = $climate->arguments->get('databaseName') ?: $this->dbName;
        $dbUser     = $climate->arguments->get('databaseUser') ?: $this->dbUser;
        $dbPassword = $climate->arguments->get('databasePassword') ?: $this->dbPassword;
        $dbHost     = $climate->arguments->get('databaseHost') ?: $this->dbHost;
        $verbose    = !!$climate->arguments->get('quiet');
        $this->setVerbose($verbose);

        // Detect the APPLICATION ENVIRONMENT var.
        $env = $this->getEnv();
        $climate->out(sprintf(
            'The APPLICATION ENVIRONMENT is "%s"',
            $env
        ));

        // Prompt for database name until correctly entered
        do {
            $dbName = $this->promptDbName($dbName);
        } while (!$dbName);

        // Prompt for database user name until correctly entered
        do {
            $dbUser = $this->promptDbUser($dbUser);
        } while (!$dbUser);

        // Prompt for database password until correctly entered
        do {
            $dbPassword = $this->promptDbPassword($dbPassword);
        } while (!$dbPassword);

        // Prompt for database host until correctly entered
        do {
            $dbHost = $this->promptDbHost($dbHost);
        } while (!$dbHost);

        // Database creation
        $this->createDb();

        // Create the config.env.json file.
        $this->createConfigFile();

        // Modify database data
        $this->updateDatabaseData();

        $climate->green()->out("\n".'The project was configured with Success!');
    }

    /**
     * Creates the database for the user,
     * using a supplied sql database.
     *
     * @return void
     */
    private function createDb()
    {
        $climate = $this->climate();

        $name     = $this->dbName();
        $username = $this->dbUser();
        $password = $this->dbPassword();
        $host     = $this->dbHost();

        // Output database creation data
        $climate->out('Creating database using :');
        $climate->table([
            [
                'Name'     => '<green>'.$name.'</green>',
                'User'     => '<green>'.$username.'</green>',
                'Password' => '<green>'.$password.'</green>',
                'Hostname' => '<green>'.$host.'</green>',
            ]
        ]);

        // Set UTf-8 compatibility by default. Disable it if it is set as such in config
        $extraOptions = null;
        if (!isset($dbConfig['disable_utf8']) || !$dbConfig['disable_utf8']) {
            $extraOptions = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
        }

        $dsn = 'mysql:host='.$host;
        $db  = new PDO($dsn, $username, $password, $extraOptions);

        // Set PDO options
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        $q = "SELECT COUNT(*)
              FROM INFORMATION_SCHEMA.SCHEMATA
              WHERE SCHEMA_NAME = '".$name."'";

        $dbExist = $db->query($q);

        if (!$dbExist->fetchColumn()) {
            $climate->out('database does not exist...');
            $climate->out('creating database...');

            $q = 'CREATE DATABASE IF NOT EXISTS '.$name.'';
            $db->query($q);
        }

        $q = 'USE '.$name.'';
        $db->query($q);

        $q = file_get_contents($this->rootPath.$this->sqlPath);
        $db->query($q);

        $climate->green()->out(sprintf(
            'The database %s was successfully created!',
            $name
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
     * @todo Update the database with dates baesd on today().
     * @return void
     */
    private function updateDatabaseData()
    {
    }

    /**
     * @param string|null $prompt The prompt string.
     * @return string|null
     */
    private function promptDbName($prompt = null)
    {
        if (!$prompt) {
            $input  = $this->climate()->input(
                'Database <red>name</red> : (Doesn\'t need to exist but if it does, it will be overwritten)'
            );
            $prompt = $input->prompt();
        }

        try {
            $this->setDbName($prompt);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $prompt;
    }

    /**
     * @param string|null $prompt The prompt string.
     * @return string|null
     */
    private function promptDbUser($prompt = null)
    {
        if (!$prompt) {
            $input = $this->climate()->input(sprintf(
                'Database <red>username</red> : [default: <green>%s</green>]',
                $this->defaultDbUser
            ));
            $input->defaultTo($this->defaultDbUser);
            $prompt = $input->prompt();
        }

        try {
            $this->setDbUser($prompt);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $prompt;
    }

    /**
     * @param string|null $prompt The prompt string.
     * @return string|null
     */
    private function promptDbPassword($prompt = null)
    {
        if (!$prompt) {
            $input = $this->climate()->input(
                'Database <red>password</red> :'
            );
            $input->defaultTo($this->defaultDbPassword);
            $prompt = $input->prompt();
        }

        try {
            $this->setDbPassword($prompt);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $prompt;
    }

    /**
     * @param string|null $prompt The prompt string.
     * @return string|null
     */
    private function promptDbHost($prompt = null)
    {
        if (!$prompt) {
            $input = $this->climate()->input(sprintf(
                'Database <red>hostname</red> : [default: <green>%s</green>]',
                $this->defaultDbHost
            ));
            $input->defaultTo($this->defaultDbHost);
            $prompt = $input->prompt();
        }

        try {
            $this->setDbHost($prompt);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $prompt;
    }

    // ==========================================================================
    // SETTERS
    // ==========================================================================

    /**
     * Set database name.
     *
     * @param string $name The database name.
     * @throws InvalidArgumentException If the name is invalid.
     * @return ConfigScript Chainable
     */
    public function setDbName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(
                'Invalid database name. Must be a string.'
            );
        }

        if (!$name) {
            throw new InvalidArgumentException(
                'Invalid project name. Must contain at least one character.'
            );
        }

        if (!preg_match('/^[-a-z_ ]+$/i', $name)) {
            throw new InvalidArgumentException(
                'Invalid database name. Only characters A-Z, dashes, underscores and spaces are allowed.'
            );
        }

        $this->dbName = $name;

        return $this;
    }

    /**
     * Set database username.
     *
     * @param string $name The database name.
     * @throws InvalidArgumentException If the username is invalid.
     * @return ConfigScript Chainable
     */
    public function setDbUser($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(
                'Invalid database username. Must be a string.'
            );
        }

        if (!$name) {
            throw new InvalidArgumentException(
                'Invalid project username. Must contain at least one character.'
            );
        }

        if (!preg_match('/^[-a-z_ ]+$/i', $name)) {
            throw new InvalidArgumentException(
                'Invalid database name. Only characters A-Z, dashes, underscores and spaces are allowed.'
            );
        }

        $this->dbUser = $name;

        return $this;
    }

    /**
     * Set database password.
     *
     * @param string $password The database password.
     * @throws InvalidArgumentException If the password is invalid.
     * @return ConfigScript Chainable
     */
    public function setDbPassword($password)
    {
        if (!is_string($password)) {
            throw new InvalidArgumentException(
                'Invalid database password. Must be a string.'
            );
        }

        $this->dbPassword = $password;

        return $this;
    }

    /**
     * Set database hostname.
     *
     * @param string $name The database hostname.
     * @throws InvalidArgumentException If the hostname is invalid.
     * @return ConfigScript Chainable
     */
    public function setDbHost($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(
                'Invalid database password. Must be a string.'
            );
        }

        if (!$name) {
            throw new InvalidArgumentException(
                'Invalid project username. Must contain at least one character.'
            );
        }

        $this->dbHost = $name;

        return $this;
    }

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
        return $this->dbName;
    }

    /**
     * Retrieve the database user name.
     *
     * @return string
     */
    public function dbUser()
    {
        return $this->dbUser;
    }

    /**
     * Retrieve the database password.
     *
     * @return string
     */
    public function dbPassword()
    {
        return $this->dbPassword;
    }

    /**
     * Retrieve the database host.
     *
     * @return string
     */
    public function dbHost()
    {
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
}
