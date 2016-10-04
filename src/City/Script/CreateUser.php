<?php

namespace City\Script;

use \Exception;
use \InvalidArgumentException;
use League\CLImate\CLImate;

/**
 * Class CreateUser.
 */
class CreateUser
{
    /**
     * @var  $userName
     */
    protected $userName;
    /**
     * @var  $userPassword
     */
    protected $userPassword;
    /**
     * @var  $userEmail
     */
    protected $userEmail;

    /**
     * @var CLImate $climate
     */
    private $climate;

    /**
     * constructor function
     */
    public function __construct()
    {
        $this->createUser();
    }

    /**
     * Create an admin user by prompting the client.
     * @return void
     * @throws CancelledScriptException When a cancel action is made by the user.
     */
    protected function createUser()
    {
        // Prompt for user name until correctly entered
        do {
            $userName = $this->promptUserName(null);
        } while ($userName === null);

        if (!$userName) {
            throw new CancelledScriptException(
                'The admin user creation as been skipped.'
            );
        }

        // Prompt for user email until correctly entered
        do {
            $userEmail = $this->promptUserEmail(null);
        } while (!$userEmail);
        // Prompt for user password until correctly entered
        do {
            $userPassword = $this->promptUserPassword(null);
        } while (!$userPassword);

        // Create the admin user
        exec(sprintf(
            'vendor/bin/charcoal admin/user/create -u %s -e %s -p $s -r admin 2>&1',
            $userName,
            $userEmail,
            $userPassword
        ), $output);

        $this->climate()->dim()->out($output);
    }

    /**
     * Safe climate getter.
     * If the instance was not previously set, create it.
     *
     * > CLImate is "PHP's best friend for the terminal."
     * > "CLImate allows you to easily output colored text, special formats, and more."
     *
     * @return CLImate
     */
    protected function climate()
    {
        if ($this->climate === null) {
            $this->climate = new CLImate();
        }

        return $this->climate;
    }

    /**
     * @param string $name The user name.
     * @return string|null
     */
    protected function promptUserName($name = null)
    {
        if (!$name) {
            $input = $this->climate()->input('User <red>name</red> (leave blank if you want to skip user creation :)');
            $name  = $input->prompt();
        }

        try {
            $this->setUserName($name);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $name;
    }

    /**
     * @param string $email The user email.
     * @return string|null
     */
    protected function promptUserEmail($email = null)
    {
        if (!$email) {
            $input = $this->climate()->input('User <red>email</red> :');
            $email = $input->prompt();
        }

        try {
            $this->setUserEmail($email);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $email;
    }

    /**
     * @param string $password The user email.
     * @return string|null
     */
    protected function promptUserPassword($password = null)
    {
        if (!$password) {
            $input    = $this->climate()->password('User <red>password</red> :');
            $password = $input->prompt();
        }

        try {
            $this->setUserPassword($password);
        } catch (Exception $e) {
            $this->climate()->error($e->getMessage());

            return null;
        }

        return $password;
    }

    // ==========================================================================
    // SETTERS
    // ==========================================================================

    /**
     * Set the user name.
     *
     * @param string $name The user name.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return self Chainable
     */
    public function setUserName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(
                'Invalid user name. Must be a string.'
            );
        }

        if ($name != '' && !preg_match('/^[-a-z_ ]+$/i', $name)) {
            throw new InvalidArgumentException(
                'Invalid user name. Only characters A-Z, dashes, underscores and spaces are allowed.'
            );
        }

        $this->userName = $name;

        return $this;
    }

    /**
     * Set the user email.
     *
     * @param string $email The user email.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return self Chainable
     */
    public function setUserEmail($email)
    {
        if (!is_string($email)) {
            throw new InvalidArgumentException(
                'Invalid user email. Must be a string.'
            );
        }

        if (!$email) {
            throw new InvalidArgumentException(
                'Invalid user email. Must contain at least one character.'
            );
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Invalid user email. Not a valid email, something is missing.'
            );
        }

        $this->userEmail = $email;

        return $this;
    }

    /**
     * Set the user password.
     *
     * @param string $password The user password.
     * @throws InvalidArgumentException If the project name is invalid.
     * @return self Chainable
     */
    public function setUserPassword($password)
    {
        if (!is_string($password)) {
            throw new InvalidArgumentException(
                'Invalid user email. Must be a string.'
            );
        }

        if (!$password) {
            throw new InvalidArgumentException(
                'Invalid user email. Must contain at least one character.'
            );
        }

        $this->userPassword = $password;

        return $this;
    }
}
