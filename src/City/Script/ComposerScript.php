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
class ComposerScript extends AbstractScript
{
    use KeyNormalizerTrait;
    /**
     * @var string $rootPath The project root path.
     */
    protected $rootPath = __DIR__.'/../../../';

    /**
     * @var string $projectName The project name.
     */
    protected $projectName;

    /**
     * @var string $projectRepo The project vcs repository.
     */
    protected $projectRepo;

    /**
     * @var string $siteUrl The project website url.
     */
    protected $siteUrl;

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
            'projectName' => [
                'prefix'      => 'p',
                'longPrefix'  => 'project-name',
                'description' => 'Database host name'
            ],
            'projectRepo' => [
                'prefix'      => 'r',
                'longPrefix'  => 'repo',
                'description' => 'Database host name'
            ],
            'siteUrl'     => [
                'prefix'      => 'su',
                'longPrefix'  => 'site-url',
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
        $script = new ComposerScript();

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
        $script->composer();
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
        $this->composer();
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
     * - Set the composer.json with the correct info
     * - Change the readme according to the config
     * - ask and create vcs repository
     * - dump the auto-loader
     * @return void
     */
    private function composer()
    {
        $climate = $this->climate();

        $climate->underline()->green()->out('Charcoal city composer script');

        if ($climate->arguments->defined('help')) {
            $climate->usage();

            return;
        }

        // Parse the received arguments
        $climate->arguments->parse();
        $projectName = $climate->arguments->get('projectName') ?: $this->projectName;
        $projectRepo = $climate->arguments->get('projectRepo') ?: $this->projectRepo;
        $siteUrl     = $climate->arguments->get('siteUrl') ?: $this->siteUrl;
        $verbose     = !!$climate->arguments->get('quiet');
        $this->setVerbose($verbose);

        // Prompt for project name until correctly entered
        do {
            $projectName = $this->promptName($projectName);
        } while (!$projectName);

        // Prompt for project repo until correctly entered
        do {
            $projectRepo = $this->promptRepo($projectRepo);
        } while ($projectRepo != null);

        // Prompt for website url until correctly entered
        do {
            $siteUrl = $this->promptUrl($siteUrl);
        } while ($siteUrl != null);

        if (!!$projectRepo) {
            $climate->out(sprintf('Using "%s" as vcs repository...', $this->projectRepo()));
        }
        if (!!$siteUrl) {
            $climate->out(sprintf('Using "%s" as site url...', $this->siteUrl()));
        }

        // Update the composer file
        $this->updateComposer();

        // Update the README file
        $this->updateReadme();

        // Update git vcs repo push url
        if (!!$projectRepo) {
            $this->gitSetup();
        }

        // Dump auto-loader
        $this->dumpAutoLoader();

        $climate->green()->out("\n".'The composer was updated with Success!');
    }

    /**
     * Update the composer file
     * @return void
     */
    private function updateComposer()
    {
        $climate = $this->climate();

        $climate->out('Updating composer file...');

        $composerPath = $this->rootPath.'composer.json';
        $jsonString   = file_get_contents($composerPath);
        $data         = json_decode($jsonString, true);

        $repo = $this->projectRepo();

        // set the data
        $data['description'] = sprintf('A project for %s city', $this->projectName());
        if (!!$this->siteUrl()) {
            $data['homepage'] = $this->siteUrl();
        }

        // If no repo name get the one from installed git repo
        if (!$repo) {
            $repo = shell_exec('git config --get remote.origin.url');
        }
        $data['name']              = parse_url($repo, PHP_URL_PATH);
        $data['support']['source'] = $repo.'/src';
        $data['support']['issues'] = $repo.'/issues';
        // Change the script called by composer create-project
        $data['scripts']['post-create-project-cmd'] = ['City\\Script\\SetupScript::start'];

        $newJsonString = json_encode($data, (JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        file_put_contents($composerPath, $newJsonString);

        $climate->green()->out('Composer file updated with success!');
    }

    /**
     * Update the readme to indicate the installation method of a started project.
     * @return void
     */
    private function updateReadme()
    {
        $this->climate()->out('Updating the README.md file...');

        $newReadme = file_get_contents($this->rootPath.'build/README.md.post-install');

        $newReadme = preg_replace('~^<project-name>$~i', $this->projectName(), $newReadme);

        $repo = $this->projectRepo();

        if (!$repo) {
            $repo = shell_exec('git config --get remote.origin.url');
        }
        $newReadme = preg_replace('~^<project-repo-name>$~i', $repo, $newReadme);

        file_put_contents($this->rootPath.'README.md', $newReadme);
    }

    /**
     * Setup the git configuration to push to the chosen repository
     * @return void
     */
    private function gitSetup()
    {
        $this->climate()->out(sprintf(
            'Setting the git environment to push to %s...',
            $this->projectRepo()
        ));

        exec('rm -rf .git');
        // initialize git.
        exec('git init');
        // set teh remote repo.
        exec(sprintf(
            'git remote add origin %s',
            $this->projectRepo()
        ));

        // verify the remote repo.
        exec('git remote -v 2>&1', $output);
        $this->climate()->dim()->out($output);
    }

    /**
     * Dump the auto-loader to refresh the src paths
     * @return void
     */
    private function dumpAutoLoader()
    {
        $this->climate()->out('refreshing the auto-loader...');

        exec('composer dump-autoload');
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
     * @param string $repo The repo of the project.
     * @return string|null
     */
    protected function promptRepo($repo = null)
    {
        if (!$repo) {
            $input = $this->climate()->input('What is the <red>VCS repository</red> of the project? '.
                '(<red>let blank to use an already installed VCS</red>) :');
            $repo  = strtolower($input->prompt());
        }

        try {
            $this->setProjectRepo($repo);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $repo;
    }

    /**
     * @param string $url The url of the project site.
     * @return string|null
     */
    protected function promptUrl($url = null)
    {
        if (!$url) {
            $input = $this->climate()->input('What is the project <red>website url</red>? (<red>optional</red>) :');
            $url   = strtolower($input->prompt());
        }

        try {
            $this->setSiteUrl($url);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $url;
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
     * @param string $repo The namespace of the project.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return self Chainable
     */
    public function setProjectRepo($repo)
    {
        if (!is_string($repo)) {
            throw new InvalidArgumentException(
                'Invalid VCS repository. Must be a string.'
            );
        }

        if ($repo != ''
            && !preg_match(
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
     * Set the current project namespace.
     *
     * @param string $url The website url.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return self Chainable
     */
    public function setSiteUrl($url)
    {
        if (!is_string($url)) {
            throw new InvalidArgumentException(
                'Invalid site url. Must be a string.'
            );
        }

        if ($url != ''
            && !preg_match(
                '~^(http|https)://[a-z0-9_]+([-.]{1}[a-z_0-9]+)*\.[_a-z]{2,5}((:[0-9]{1,5})?/.*)?$~i',
                $url
            )
        ) {
            throw new InvalidArgumentException(
                'Invalid site url. Only valid Urls are allowed.'
            );
        }

        $this->siteUrl = $url;

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
     * Retrieve the current project repository.
     *
     * @return string
     */
    public function projectRepo()
    {
        return $this->projectRepo;
    }

    /**
     * Retrieve the current project repository.
     *
     * @return string
     */
    public function siteUrl()
    {
        return $this->siteUrl;
    }
}
