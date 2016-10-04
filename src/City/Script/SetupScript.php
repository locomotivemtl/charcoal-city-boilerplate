<?php

namespace City\Script;

// Dependencies from PSR-7 (HTTP Messaging)
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

// Dependency from 'charcoal-app'
use \Charcoal\App\Script\AbstractScript;
use Psr\Log\NullLogger;

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
     * @throws \Exception If fatal error occurs.
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
        $verbose = !!$climate->arguments->get('quiet');
        $this->setVerbose($verbose);

        set_exception_handler(null);

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
