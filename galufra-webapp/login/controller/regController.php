<?php

require_once 'authController.php';

class regController {

    private $check_value;
    private $mysql;

    function __construct() {

        $this->check_value = array(
            "username" => "check_username",
            "name" => "check",
            "surname" => "check",
            "password" => "check",
            "mail" => "check",
            "city" => "check",
        );

        $this->mysql = new mysqlController();
        $result = $this->mysql->connect();
        if (!$result[0]) {
            die("error in" . $result[1] . "\n");
        }
    }

    //used by jquery
    public function checkUsername($value) {

        $value = trim($value);
        if (get_magic_quotes_gpc ())
            $value = stripslashes($value);
        $value = mysql_real_escape_string($value);

        //null value is checked by javascript

        $result = $this->mysql->makeQuery(
                        "SELECT id FROM " . Authorization::$_TABLE["user_table"] . "
	WHERE username='" . $value . "'"
        );

        if ($result[0]) {
            if (mysql_affected_rows () != 0)
                return ("username already in use");
        }
        else {

            die("error in" . $result[1] . "\n");
        }

        return true;
    }

    //used by jquery
    public function checkOthers($value) {

        if (trim($value) == "")
            return false;

        return true;
    }

    public function getUniqueId() {
        //return an unique id for registration

        list($usec, $sec) = explode(' ', microtime());
        mt_srand((float) $sec + ((float) $usec * 100000));
        return md5(uniqid(mt_rand(), true));
    }

    public function sendConfirmationMail($to, $from, $id) {

        $msg = "Hello! To confirm your galufra registration click here:
	http://localhost/login/confirm.php?id=" . $id . "";
        $status = mail($to, "Conferma la registrazione", $msg, "From: ". $from) ? REG_SUCCESS : REG_FAILED;

        return $status;
    }

    public function register($data) {

        $id = $this->getUniqueId();
        $query = "INSERT INTO " . Authorization::$_TABLE["user_table"] . " (id_utente,username, password, nome, cognome, mail, citta, confirmed, date, uid)
         VALUES ('NULL','" . $data["uname"] . "',MD5('" . $data["pwd"] . "'),'" . $data["name"] . "','" . $data["sname"] . "','" . $data["email"] . "','" . $data["city"] . "','1','"
                        .time(). "','" . $id . "')";

        $result = $this->mysql->makeQuery($query);


        if (!mysql_insert_id()) {
            return $this->sendConfirmationMail($data["email"], "localhost@localhost.it", $id);
        }else
            return REG_FAILED;
        
    }

    public function cleanExpired() {

        $result = $this->mysql->makeQuery(
                        "DELETE FROM " . Authorization::$_TABLE["user_table"] . " WHERE (date + 24*60*60) <= " . time() . " and temp='1'"
        );
        if ($result[0])
            return true;
        else
            return false;
    }

    public function Confirm($id) {

        $query = $this->mysql->makeQuery("
	UPDATE " . Authorization::$_TABLE["user_table"] . "
	SET temp='0'
	WHERE uid='" . $id . "'");

        return (mysql_affected_rows () != 0) ? REG_SUCCESS : REG_FAILED;
    }

    public function validateEmail($email) {
    
        $normal = "^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$^";
        $validButRare = "^[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+(\.[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,})$^";
        
        if (preg_match($normal, $email)) {
            return true;
        } else if (preg_match($validButRare, $email)) {
            return true;
        } else {
            return false;
        }
    }

}

?>
