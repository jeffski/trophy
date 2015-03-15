<?php 

namespace Trophy\Utils;

use Trophy\Config\Config;

class Login
{
    private $username;
    private $password;

    public function __construct()
    {
        $config = Config::getConfig();
        $this->username = $config->login_username;
        $this->password = $config->login_password;
    }

    /**
     * Authenticate
     *
     * Show the HTTP Login Form and check the username and password based on config file
     */
    public function authenticate()
    {
        $login_successful = false;

        list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) =
            explode(':', base64_decode(substr($_SERVER['HTTP_PHP_AUTH'], 6)));

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

            if ($this->checkCredentials($username, $password)) {
                $login_successful = true;
            }
        }

        if (!$login_successful) {
            header('HTTP/1.0 401 Unauthorized');
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="Secure Login"');
            die("<h1>Authorization Required</h1><p>This server could not verify that you are authorized to access the document requested.  Either you supplied the wrong credentials (e.g., bad password), or your browser doesn't understand how to supply the credentials required.</p>");
        }
    }

    /**
     * Check Credential
     *
     * Check the username and password with the configuration file 
     *
     * @param string $username
     * @param string $password
     * @return bool 
     */
    private function checkCredentials($username, $password)
    {
        if ($this->username == $username && $this->password == $password) {
            return true;
        }
        return false;
    }
}
