<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("mysqlController.php");

define('AUTH_LOGGED', 99);
define('AUTH_NOT_LOGGED', 100);
define('AUTH_INVALID_PARAMS', 104);
define('AUTH_LOGEDD_IN', 105);
define('AUTH_FAILED', 106);
define('REG_ERRORS', 107);
define('REG_SUCCESS', 108);
define('REG_FAILED', 109);

class Authorization {

    private $mysql;
    public static $_TABLE = array(
        'session_table' => 'session',
        'user_table' => 'utente',
        'expire' => 60
    );

    public function __construct() {
        $this->mysql = new mysqlController();
        $result = $this->mysql->connect();
        if (!$result[0]) {
            die("error in" . $result[1] . "\n");
        }
    }


    /* At the beginning check whether the user session expired. Then, catch every information from the user table
     * and returns an array with:
     *
     *  --AUTH_NOT_LOGGED,NULL whether the user is not logged or registered
     *  --AUTH_LOGGED, "user information"
     */

    public function getStatus() {

        session_start();

        if (isset($_SESSION['user_id'])) {

            $result = $this->mysql->makeQuery(
                   "SELECT U.nome, U.cognome, U.username, U.citta
                    FROM " . Authorization::$_TABLE['user_table'] . " U
                    WHERE U.id_utente ='" . $_SESSION['user_id'] . "'");

            if (mysql_num_rows($result[1]) != 1)
                return array(AUTH_NOT_LOGGED, NULL);

            else {
                $user_data = mysql_fetch_assoc($result[1]);
                return array(AUTH_LOGGED, $user_data);
            }
        }

        return array(AUTH_NOT_LOGGED, NULL);
    }

    /* Makes a "SELECT * FROM" with uname and passw and returns an array with:
     *
     *  --AUTH_INVALID_PARAMS,NULL whether uname and passw doesn't match anything
     *  --AUTH_LOGGED_IN, "user data" wheter uname and passw has been found
     */

    public function Login($uname, $passw) {

        $result = $this->mysql->makeQuery("
	SELECT *
	FROM " . Authorization::$_TABLE['user_table'] . "
	WHERE username='" . $uname . "' and password=MD5('" . $passw . "')"
        );

        if (mysql_num_rows($result[1]) != 1) {
            return array(AUTH_INVALID_PARAMS, NULL);
        } else {
            $data = mysql_fetch_array($result[1]);
            $this->registerSession($data);
            return array(AUTH_LOGEDD_IN, $data);
        }
    }

    /* Writes into the "$_SESSION" the user-id */

    private function registerSession($udata) {

        session_unset();
        session_destroy();
        session_start();
        session_set_cookie_params(3600);
        $_SESSION['user_id'] = $udata['id_utente'];

    }

    /* Destroy the user session */

    public function auth_logout() {

        session_start();
        if (isset($_SESSION['user_id'])) {
            session_unset();
            session_destroy();
            return true;
        }
        
        return false;
    }

}

?>
