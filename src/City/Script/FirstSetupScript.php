<?php

namespace City\Script;

use \Exception;
use \InvalidArgumentException;

// Dependencies from PSR-7 (HTTP Messaging)
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

// Dependency from 'charcoal-app'
use \Charcoal\App\Script\AbstractScript;
use Psr\Log\NullLogger;

// From 'league/climate'
use \League\CLImate\CLImate;

/**
 * Renames the current module's name
 *
 * The command-line action will alter the module's
 * file names and the contents of files to match
 * the provided name.
 */
class FirstSetupScript extends AbstractScript
{
    use KeyNormalizerTrait;

    /**
     * @var string $sourceName The default string to search and replace.
     */
    protected $defaultSourceName = 'boilerplate';

    /**
     * @var string $projectName The user-provided name of the project.
     */
    protected $projectName;

    /**
     * @var string $projectNamespace The namespace of the project.
     */
    protected $projectNamespace;

    /**
     * @var string $illegalNames Names that will return an error.
     */
    protected $illegalNames = '~^(charcoal|city)$~i';

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
            'projectName'      => [
                'prefix'      => 'n',
                'longPrefix'  => 'name',
                'description' => 'Project name.'
            ],
            'projectNamespace' => [
                'prefix'      => 'ns',
                'longPrefix'  => 'namespace',
                'description' => 'Project namespace.'
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
        if (!isset($data['climate'])) {
            $data['climate'] = new CLImate();
        }

        parent::__construct($data);

        $arguments = $this->defaultArguments();
        $this->setArguments($arguments);
    }

    /**
     * Create a new setup script and runs it
     * @return void
     */
    public static function start()
    {
        $setupScript = new FirstSetupScript();
        $setupScript->setup();
    }

    /**
     * @see \League\CLImate\CLImate Used by `CliActionTrait`
     * @param RequestInterface  $request  PSR-7 request.
     * @param ResponseInterface $response PSR-7 response.
     * @return void
     */
    public function run(RequestInterface $request = null, ResponseInterface $response = null)
    {
        // Never Used
        unset($request, $response);
        $this->setup();
    }

    // ==========================================================================
    // FUNCTIONS
    // ==========================================================================

    /**
     * Interactively setup a City project.
     *
     * The action will ask the user a series of questions,
     * and then update the current city project for them.
     * @return void
     * @throws Exception If fatal error occurs.
     */
    public function setup()
    {
        $climate = $this->climate();

        $climate->underline()->green()->out('Charcoal City setup script');

        if ($climate->arguments->defined('help')) {
            $climate->usage();

            return;
        }

        // Parse submitted arguments
        $climate->arguments->parse();
        $projectName      = $climate->arguments->get('projectName');
        $projectNamespace = $climate->arguments->get('projectNamespace');
        $verbose          = !!$climate->arguments->get('quiet');
        $this->setVerbose($verbose);

        // Prompt for project name until correctly entered
        do {
            $projectName = $this->promptName($projectName);
        } while (!$projectName);
        // Prompt for project namespace until correctly entered
        do {
            $projectNamespace = $this->promptNamespace($projectNamespace);
        } while (!$projectNamespace);

        $climate->bold()->out(sprintf('Using "%s" as project name...', $this->projectName()));
        $climate->out(sprintf('Using "%s" as namespace...', $this->projectNamespace()));

        // Rename the project's files and content
        RenameScript::start([
            'sourceName' => $this->defaultSourceName,
            'targetName' => $this->projectNamespace()
        ]);
        // Modify the composer file
        ComposerScript::start([
            'projectName' => $this->projectName()
        ]);

        try {
            // Configure database and the config file
            ConfigScript::start();
            // Create a user
            new CreateUser();
        } catch (CancelledScriptException $e) {
            $climate->out($e->getMessage());
        }

        $climate->green()->out("\n".'Success!');
    }

    /**
     * @param string $name The name of the project.
     * @return string|null
     */
    protected function promptName($name = null)
    {
        if (!$name) {
            $input = $this->climate()->input('What is the <red>name</red> of the project?');
            $name  = ucfirst($input->prompt());
        }

        try {
            $this->setProjectName($name);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $name;
    }

    /**
     * @param string $name The namespace of the project.
     * @return string|null
     */
    protected function promptNamespace($name = null)
    {
        if (!$name) {
            $generatedNamespace = self::studly($this->projectName());
            $input              = $this->climate()->input(sprintf(
                'What is the <red>namespace</red> of the project? [default: <green>%s</green>]',
                $generatedNamespace
            ));
            $input->defaultTo($generatedNamespace);
            $name = $input->prompt();
        }

        try {
            $this->setProjectNamespace($name);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $name;
    }

    // ==========================================================================
    // SETTERS
    // ==========================================================================

    /**
     * Set the current project name.
     *
     * @param string $name The name of the project.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return self Chainable
     */
    public function setProjectName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(
                'Invalid project name. Must be a string.'
            );
        }

        if (!$name) {
            throw new InvalidArgumentException(
                'Invalid project name. Must contain at least one character.'
            );
        }

        if (preg_match($this->illegalNames, $name)) {
            throw new InvalidArgumentException(
                'Invalid project name. The name chosen is illegal.'
            );
        }

        if (!preg_match('/^[-a-z_ ]+$/i', $name)) {
            throw new InvalidArgumentException(
                'Invalid project name. Only characters A-Z, dashes, underscores and spaces are allowed.'
            );
        }

        $this->projectName = $name;

        return $this;
    }

    /**
     * Set the current project namespace.
     *
     * @param string $namespace The namespace of the project.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return self Chainable
     */
    public function setProjectNamespace($namespace)
    {
        if (!is_string($namespace)) {
            throw new InvalidArgumentException(
                'Invalid namespace. Must be a string.'
            );
        }

        if (!$namespace) {
            throw new InvalidArgumentException(
                'Invalid namespace. Must contain at least one character.'
            );
        }

        if (preg_match($this->illegalNames, $namespace)) {
            throw new InvalidArgumentException(
                'Invalid project namespace. The namespace chosen is illegal.'
            );
        }

        if (!preg_match('/^[-a-z_ ]+$/i', $namespace)) {
            throw new InvalidArgumentException(
                'Invalid project name. Only characters A-Z, dashes, underscores and spaces are allowed.'
            );
        }
        // Convert to studly
        $namespace              = self::studly($namespace);
        $this->projectNamespace = $namespace;

        return $this;
    }

    // ==========================================================================
    // GETTERS
    // ==========================================================================

    /**
     * Retrieve the current project name.
     *
     * @return string
     */
    public function projectName()
    {
        return $this->projectName;
    }

    /**
     * Retrieve the current project namespace.
     *
     * @return string
     */
    public function projectNamespace()
    {
        return $this->projectNamespace;
    }

    /**
     * Retrieve the response to the action.
     *
     * @return array
     */
    public function response()
    {
        return [
            'success' => $this->success()
        ];
    }
}
