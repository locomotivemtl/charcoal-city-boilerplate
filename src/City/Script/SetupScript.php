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
     * @var string $projectRpo The VCS repository of the project.
     */
    protected $projectRepo;

    /**
     * SetupScript constructor Register the action's arguments..
     */
    public function __construct()
    {
        $arguments = $this->defaultArguments();
        $this->setArguments($arguments);
    }

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
            'projectName'       => [
                'prefix'      => 'n',
                'longPrefix'  => 'name',
                'description' => 'Project name.'
            ],
            'projectNamespace'  => [
                'Prefix'      => 'ns',
                'longPrefix'  => 'namespace',
                'description' => 'Project namespace.'
            ],
            'projectRepository' => [
                'Prefix'      => 'r',
                'longPrefix'  => 'repo',
                'description' => 'Project VCS repository name.'
            ]
        ];

        $arguments = array_merge(parent::defaultArguments(), $arguments);

        return $arguments;
    }

    /**
     * Set the current project name.
     *
     * @param string $name The name of the project.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return SetupScript Chainable
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

        if (!preg_match('/^[a-z]+$/', $name)) {
            throw new InvalidArgumentException(
                'Invalid project name. Only characters A-Z in lowercase are allowed.'
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
     * @return SetupScript Chainable
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

        if (!preg_match('/^[a-zA-Z]+$/', $namespace)) {
            throw new InvalidArgumentException(
                'Invalid namespace. Only characters A-Z in lowercase are allowed.'
            );
        }

        $this->projectNamespace = $namespace;

        return $this;
    }

    /**
     * Set the current project namespace.
     *
     * @param string $repo The namespace of the project.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return SetupScript Chainable
     */
    public function setProjectRepo($repo)
    {
        if (!is_string($repo)) {
            throw new InvalidArgumentException(
                'Invalid VCS repository. Must be a string.'
            );
        }

        if (!$repo) {
            throw new InvalidArgumentException(
                'Invalid VCS repository. Must contain at least one character.'
            );
        }

        if (!preg_match(
            '~^(http|https)://[a-z0-9_]+([-.]{1}[a-z_0-9]+)*\.[_a-z]{2,5}((:[0-9]{1,5})?/.*)?$~i',
            $repo
        )
        ) {
            throw new InvalidArgumentException(
                'Invalid VCS repository. Only valid Urls are allowed.'
            );
        }

        $this->projectRepo = $repo;

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
     * Retrieve the current project repository.
     *
     * @return string
     */
    public function projectRepo()
    {
        return $this->projectRepo;
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

        $climate = $this->climate();

        $climate->underline()->out('Charcoal City setup script');

        if ($climate->arguments->defined('help')) {
            $climate->usage();

            return;
        }

        $climate->arguments->parse();
        $projectName      = $climate->arguments->get('projectName');
        $projectNamespace = $climate->arguments->get('projectNamespace');
        $projectRepo      = $climate->arguments->get('projectRepository');
        $verbose          = !!$climate->arguments->get('quiet');
        $this->setVerbose($verbose);

        if (!$projectName) {
            $input       = $climate->input('What is the name of the project?');
            $projectName = strtolower($input->prompt());
        }

        try {
            $this->setProjectName($projectName);
        } catch (Exception $e) {
            $climate->error($e->getMessage());
        }

        if (!$projectNamespace) {
            $input            = $climate->input('What is the namespace of the project?');
            $projectNamespace = strtolower($input->prompt());
        }

        try {
            $this->setProjectNamespace($projectNamespace);
        } catch (Exception $e) {
            $climate->error($e->getMessage());
        }

        if (!$projectRepo) {
            $input       = $climate->input('What is the VCS repository of the project?');
            $projectRepo = strtolower($input->prompt());
        }

        try {
            $this->setProjectRepo($projectRepo);
        } catch (Exception $e) {
            $climate->error($e->getMessage());
        }

        $climate->bold()->out(sprintf('Using "%s" as project name...', $projectName));
        $climate->out(sprintf('Using "%s" as namespace...', ucfirst($projectName)));

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
