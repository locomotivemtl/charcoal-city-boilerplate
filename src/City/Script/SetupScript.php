<?php

namespace City\Script;

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
     * Setup function called after the project creation.
     * @return void
     */
    public static function setup()
    {
        $setup   = new SetupScript();
        $climate = $setup->climate();

        $climate->underline()->out('Charcoal City setup script');

        if ($climate->arguments->defined('help')) {
            $climate->usage();

            return;
        }

        $climate->arguments->parse();
        $verbose = !!$climate->arguments->get('quiet');
        $setup->setVerbose($verbose);

        $input       = $climate->input('What is the name of the project?');
        $projectName = strtolower($input->prompt());

        try {
            $setup->setProjectName($projectName);
        } catch (Exception $e) {
            $climate->error($e->getMessage());
        }

        $climate->bold()->out(sprintf('Using "%s" as project name...', $projectName));
        $climate->out(sprintf('Using "%s" as namespace...', ucfirst($projectName)));
    }

    /**
     * Set the current project name.
     *
     * @param string $projectName The name of the project.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return SetupScript Chainable
     */
    public function setProjectName($projectName)
    {
        if (!is_string($projectName)) {
            throw new InvalidArgumentException(
                'Invalid project name. Must be a string.'
            );
        }

        if (!$projectName) {
            throw new InvalidArgumentException(
                'Invalid project name. Must contain at least one character.'
            );
        }

        if (!preg_match('/^[a-z]+$/', $projectName)) {
            throw new InvalidArgumentException(
                'Invalid project name. Only characters A-Z in lowercase are allowed.'
            );
        }

        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Set the current project namespace.
     *
     * @param string $projectNamespace The namespace of the project.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return SetupScript Chainable
     */
    public function setProjectNamespace($projectNamespace)
    {
        if (!is_string($projectNamespace)) {
            throw new InvalidArgumentException(
                'Invalid source projectNamespace name. Must be a string.'
            );
        }

        if (!$projectNamespace) {
            throw new InvalidArgumentException(
                'Invalid source projectNamespace name. Must contain at least one character.'
            );
        }

        if (!preg_match('/^[a-z]+$/', $projectNamespace)) {
            throw new InvalidArgumentException(
                'Invalid source projectNamespace name. Only characters A-Z in lowercase are allowed.'
            );
        }

        $this->projectNamespace = $projectNamespace;

        return $this;
    }

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

    /**
     * Interactively setup a City project.
     *
     * The action will ask the user a series of questions,
     * and then update the current city project for them.
     *
     * @see \League\CLImate\CLImate Used by `CliActionTrait`
     * @param RequestInterface  $request  PSR-7 request.
     * @param ResponseInterface $response PSR-7 response.
     * @return void
     */
    public function run(RequestInterface $request, ResponseInterface $response)
    {
        // Never Used
        unset($request, $response);

        // Verify current namespace
        if ($sourceName == $this->defaultSourceName) {
            $input = $climate->confirm(sprintf(
                'Is "%s" the current project namespace?',
                $this->defaultSourceName
            ));
            if ($input->confirmed()) {
                $sourceName = $this->defaultSourceName;
            } else {
                $input      = $climate->input('What is the current project namespace?');
                $sourceName = strtolower($input->prompt());
            }
        }

        try {
            $this->setSourceName($sourceName);
        } catch (Exception $e) {
            $climate->error($e->getMessage());
        }

        // Replace file contents
        $this->replaceFileContent();

        // Rename files
        $this->renameFiles();

        $climate->green()->out("\n".'Success!');
    }

    /**
     * Recursively find pathnames matching a pattern
     *
     * @see glob() for a description of the function and its parameters.
     *
     * @param string  $pattern The search pattern.
     * @param integer $flags   The glob flags.
     * @return array Returns an array containing the matched files/directories,
     *                         an empty array if no file matched or FALSE on error.
     */
    private function globRecursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern).'/*', (GLOB_ONLYDIR | GLOB_NOSORT)) as $dir) {
            if (!preg_match($this->excludeFromGlob, $dir)) {
                $files = array_merge($files, $this->globRecursive($dir.'/'.basename($pattern), $flags));
            }
        }

        return $files;
    }
}
