<?php

/*
 * This class manages the users permission.
 * 
 * 
 */

require_once ('mysqlController.php');
require_once ('authController.php');

class permissionController {

    private $mysql;

    public function __construct() {

        $this->mysql = new mysqlController();
        $result = $this->mysql->connect();
        if (!$result[0]) {
            die("error in" . $result[1] . "\n");
        }
    }

    /*provides the licences from the db. Returns:
     *
     *      - the permission table whether it is all right
     *      - error message otherwise
     */
    private function getLicenseList() {

        $result = $this->mysql->makeQuery(
                        "SELECT * FROM permessi"
        );

        $data = array();

        if ($result[0]) {

            while ($t = mysql_fetch_assoc($result[1])) {

                array_push($data, $t);
            }
        }else
            die("Error in " . $result[1] . ": unable to retrieve data\n");

        return $data;
    }

    /*sets the permission table with the new permission. Returns:
     *
     *  - true if it is everything ok
     *  - false otherwise
     */
    public function setPermission($id, $perm) {

        $result = $this->mysql->makeQuery(
                        "UPDATE " . Authorization::$_TABLE["user_table"] . " SET permission='" . $perm . "' WHERE id='" . $id . "'"
        );

        return $result[0];
    }

    /*Provides a new permission-id to be used*/
    private function setNewPermissionId() {

        $result = $this->mysql->makeQuery(
                        "SELECT (id*2) as next_id FROM permessi
                ORDER BY id DESC LIMIT 0,1"
        );

        if (($result[0]) AND (mysql_num_rows($result[1]) != 0)) {

            return mysql_result($result[1], 0, "next_id");
        }else
            die("Error in " . $result[1] . ": unable to set new permission\n");
    }

    /*Add the new permission-id using the setNewPermissionId() method*/
    public function addPermission($perm_name, $desc) {

        $result = $this->mysql->makeQuery(
                        "INSERT INTO permessi VALUES ('" . $this->setNewPermissionId() . "','" . $perm_name . "','" . $desc . "')"
        );

        return $result[0];
    }

    /*provides the user permissions associated to the user-id*/
    public function getUserPermission($user_id) {


        $result = $this->mysql->makeQuery(
                        "SELECT permessi FROM " . Authorization::$_TABLE["user_table"] . " WHERE id_utente='" . $user_id . "'"
        );

        $data = NULL;

        if ($result[0]) {

            $data = intval(mysql_result($result[1], 0, 'permessi'));
            $perm_list = array();
            foreach ($this->getLicenseList() as $perm) {
                if ($data & intval($perm['id'])) {
                    $perm_list = $perm;
                }
            }

            return $perm_list;
        }
        else
            die("Error in " . $result[1] . ": unable to retrieve permission data for the selected id\n");

        return $data;
    }

    
    /*checks whether the provided user permission is effectively associated to the user*/
    public function hasPermission($id, $perm_name) {

        $permission = $this->getUserPermission($id);
        $this->mysql->makeQuery(
                "SELECT id FROM permessi WHERE nome = '" . $perm_name . "'"
        );

        $data = NULL;

        if ($result[0])
            $data = mysql_result($result[1], 0, 'id');

        else
            die("error in " . $result[1] . ": unable to retrieve permission data\n");

        return intval($data) & intval($permission);
    }

}

?>
