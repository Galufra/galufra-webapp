<?php

/*
 * 
 * 
 *
 *
 * each one methods returns an array with two fields:
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

require_once realpath( dirname( __FILE__ ) ).'/../exception/dbException.php';
require_once 'dbController.php';

class mysqlController implements dbController {

    public static $_CONFIG = array(
        'host' => "localhost",
        'username' => "root",
        'password' => "M3n1n431d3",
        'dbname' => "galufra"
        );

    private $up; //boolean

    function __construct() {
        $this->up = false;
    }

    public function connect() {

        if (!$this->up) {
            try {
                                        
                $result = @mysql_connect(mysqlController::$_CONFIG['host'], mysqlController::$_CONFIG['username'], mysqlController::$_CONFIG['password']);
                if ($result == NULL) {

                    throw new dbException("Connect()", false);
                }


                $result = @mysql_select_db(mysqlController::$_CONFIG['dbname']);
                if ($result == NULL) {

                    throw new dbException("mysql_select_db()", false);
                }

                $this->up = TRUE;
                
            } catch (dbException $ex) {

                return array($ex->getCode(),$ex->getMessage());
            }
        }

        return array(true,"connection successfull!");
    }

    public function makeQuery($query) {
        if ($this->up) {

            try {

                $query = @mysql_query($query);

                if ($query == NULL){

                    throw new dbException("makeQuery()", false);
                }
                else{

                    return array(true,$query);


                }
            } catch (dbException $ex) {

                return array($ex->getCode(),$ex->getMessage());
            }
        } else {

            return array(false,"isUp()");

        }
    }

    public function close() {

        try {

            $result = @mysql_close();
            if (!$result)
                throw new dbException("close()", false);
            else{

                $this->up=false;
                return array(true,"connection closed!");

            }
        } catch (dbException $ex) {

            return array($ex->getCode(),$ex->getMessage());
        }
    }

}

?>
