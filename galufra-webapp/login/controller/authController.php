<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("mysqlController.php");

define('AUTH_LOGGED', 99);
define('AUTH_NOT_LOGGED', 100);
define('AUTH_USE_COOKIE', 101);
define('AUTH_USE_SESSION',102);
define('AUTH_USE_LINK', 103);
define('AUTH_INVALID_PARAMS', 104);
define('AUTH_LOGEDD_IN', 105);
define('AUTH_FAILED', 106);
define('REG_ERRORS', 107);
define('REG_SUCCESS', 108);
define('REG_FAILED', 109);


class Authorization {

    private $mysql;
    private $_AUTH;
    public static $_TABLE = array(
        'session_table' => 'session',
        'user_table' => 'utente',
        'expire' => 60
    );

    public function  __construct() {
        $this->_AUTH = array("TRANSICTION METHOD" => AUTH_USE_COOKIE);
        $this->mysql = new mysqlController();
        $result=$this->mysql->connect();
        if(!$result[0]) {
            die("error in" .$result[1]."\n");
        }
    }

    public function setOption($opt_name, $opt_value) {


        $this->_AUTH[$opt_name] = $opt_value;
    }

    public function getOption($opt_name) {


        return is_null($this->_AUTH[$opt_name]) ? NULL : $this->_AUTH[$opt_name];
    }

    public function cleanExpired() {

        $result = $this->mysql->makeQuery("SELECT creation_date FROM " . Authorization::$_TABLE['session_table'] . " WHERE uid='" . $this->getUid() . "'");
        if ($result[0]) {
            $data = mysql_fetch_array($result[1]);
            if ($data['creation_date']) {
                if ($data['creation_date'] + Authorization::$_TABLE['expire'] <= time()) {
                    switch ($this->getOption("TRANSICTION METHOD")) {
                        case AUTH_USE_COOKIE:
                            setcookie('uid');
                            break;
                        case AUTH_USE_LINK:
                            global $_GET;
                            $_GET['uid'] = NULL;
                            break;
                    }
                }
            }
        }

        $this->mysql->makeQuery("
	DELETE FROM " . Authorization::$_TABLE['session_table'] . "
	WHERE creation_date + " . Authorization::$_TABLE['expire'] . " <= " . time()
        );
    }

    public function getUid() {

        $uid = NULL;

        switch ($this->getOption("TRANSICTION METHOD")) {
            case AUTH_USE_COOKIE:
                global $_COOKIE;
                if(isset ($_COOKIE['uid']))
                    $uid = $_COOKIE['uid'];
                break;
            case AUTH_USE_LINK:
                global $_GET;
                if(isset ($_GET['uid']))
                    $uid = $_GET['uid'];
                break;
        }

        return $uid ? $uid : NULL;
    }

    public function getStatus() {


        $this->cleanExpired();

        $uid = $this->getUid();

        if (is_null($uid))
            return array(100, NULL);

        $result = $this->mysql->makeQuery("SELECT U.nome, U.cognome, U.username
	FROM " . Authorization::$_TABLE['session_table'] . " S," . Authorization::$_TABLE['user_table'] . " U
	WHERE S.user_id = U.id_utente and S.uid = '" . $uid . "'");

        if (mysql_num_rows($result[1]) != 1)

            return array(100, NULL);

        else {
            $user_data = mysql_fetch_assoc($result[1]);

            return array(99, array_merge($user_data, array('uid' => $uid)));
        }
    }

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
            return array(AUTH_LOGEDD_IN, $data);
        }
    }

    public function generateUid() {

        list($usec, $sec) = explode(' ', microtime());
        mt_srand((float) $sec + ((float) $usec * 100000));
        return md5(uniqid(mt_rand(), true));

    }

    public function registerSession($udata) {

        $uid = $this->generateUid();

        $this->mysql->makeQuery("
	INSERT INTO " . Authorization::$_TABLE['session_table'] . "
	(uid, user_id, creation_date)
	VALUES
	('" . $uid . "', '" . $udata['id_utente'] . "', " . time() . ")
	"
        );

        if (!mysql_insert_id()) {
            return array(AUTH_LOGEDD_IN, $uid);
        } else {
            return array(AUTH_FAILED, NULL);
        }
    }

    public function auth_logout() {

        $uid = $this->getUid();

        if (is_null($uid)) {
            return false;
        } else {
            $this->mysql->makeQuery("
		DELETE FROM " . Authorization::$_TABLE['session_table'] . "
		WHERE uid = '" . $uid . "'"
            );
            return true;
        }
    }

}

?>
