<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 *
 * each one method returns an array with two fields:
 *
 *  result[0] - true/false whether or not the method accomplishes its work
 *
 *  result[1] - provides a description message of the result (error or not)
 *              except for makeQuery() in which provides the results
 *              of the query
 *
 *
 *
 */
require_once 'exception/dbException.php';
require_once 'dbController.php';

class mysqlController implements dbController {

    private static $host = "localhost";
    private static $username = "root";
    private static $password = "nonlascrivolapassword";
    private static $dbname = "db";
    private $up; //boolean

    function __construct() {
        $this->up = false;
    }

    public function connect() {
        if (!$this->up) {
            try {

                $result = @mysql_connect(mysqlController::$host, mysqlController::$username, mysqlController::$password);
                if ($result == NULL) {

                    throw new dbException("Connect()", false);
                }


                $result = @mysql_select_db($this->dbname);
                if ($result == NULL) {

                    throw new dbException("mysql_select_db()", false);
                }

                $this->up = TRUE;
                $result[0]=true;
                $result[1]="Connection successfull!";
            } catch (dbException $ex) {

                $result[0] = $ex->getCode();
                $result[1] = $ex->getMessage();
                return $result;
            }
        }
    }

    public function makeQuery($query) {
        if ($this->up) {

            try {

                $query = @mysql_query($query);

                if ($result == NULL){

                    throw new dbException("makeQuery()", false);
                }
                else{

                    $result[0]=true;
                    $result[1]=$query;
                    return $result;

                }
            } catch (dbException $ex) {

                $result[0] = $ex->getCode();
                $result[1] = $ex->getMessage();
                return $result;
            }
        } else {

            $result[0] = false;
            $result[1] = "in isUp()";
            return $result;

        }
    }

    public function close() {

        try {

            $result = @mysql_close();
            if (!$result)
                throw new dbException("close()", false);
            else{

                $result[0]=true;
                $result[1]="connection closed!";

            }
        } catch (dbException $ex) {

            $result[0] = $ex->getCode();
            $result[1] = $ex->getMessage();
            return $result;
        }
    }

}

?>
