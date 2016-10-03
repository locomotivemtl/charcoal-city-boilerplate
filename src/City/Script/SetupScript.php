<?php

namespace City\Script;

use Charcoal\Admin\Script\User\CreateScript;
use \Exception;
use \InvalidArgumentException;

// Dependencies from PSR-7 (HTTP Messaging)
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

// Dependency from 'charcoal-app'
use \Charcoal\App\Script\AbstractScript;

/**
 * Renames the current module's name
 *
 * The command-line action will alter the module's
 * file names and the contents of files to match
 * the provided name.
 */
class SetupScript extends AbstractScript
{
    // ==========================================================================
    // INIT
    // ==========================================================================

    /**
     * SetupScript constructor Register the action's arguments..
     */
    public function __construct()
    {
        $arguments = $this->defaultArguments();
        $this->setArguments($arguments);
    }

    /**
     * Create a new setup script and runs it
     * @return void
     */
    public static function start()
    {
        $setupScript = new SetupScript();
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
     */
    public function setup()
    {
        $climate = $this->climate();

        $climate->underline()->out('Charcoal City setup script');

        if ($climate->arguments->defined('help')) {
            $climate->usage();

            return;
        }

        // Parse submitted arguments
        $climate->arguments->parse();
        $verbose = !!$climate->arguments->get('quiet');
        $this->setVerbose($verbose);

        // Configure database and the config file
        ConfigScript::start();
        // Create a user
        CreateScript::start();

        $climate->green()->out("\n".'Success!');
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
