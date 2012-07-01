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

require_once '../exception/dbException.php';
require_once 'FDb.php';
require_once '../includes/config.inc.php';

class FMysql implements FDb {

    private $up; //boolean
    private $_connection;
    private $_query;
    protected $_table;
    protected $_key;
    protected $_class;
    protected $_is_an_autoincrement_key = true;

    function __construct() {
        $this->up = false;
    }

    public function connect() {
        global $config;
        if (!$this->up) {
            try {

                $result = @mysql_connect($config['mysql']['host'],
                                         $config['mysql']['username'],
                                         $config['mysql']['password']);
                if ($result == NULL) {

                    throw new dbException("Connect()", false);
                }


                $result = @mysql_select_db($config['mysql']['dbname']);
                if ($result == NULL) {

                    throw new dbException("mysql_select_db()", false);
                }

                $this->up = TRUE;
            } catch (dbException $ex) {

                return array($ex->getCode(), $ex->getMessage());
            }
        }

        return array(true, "connection successfull!");
    }

    public function makeQuery($query) {
        if ($this->up) {
                $this->_query = mysql_query($query);

                if ($this->_query == NULL) {

                    throw new dbException(mysql_errno(), false);
                } else {

                    return array(true, $this->_query);
                }
        } else {

            return array(false, "isUp()");
        }
    }

    /*
     * Returns the result of a query in array form
     *
     */

    public function getResult() {
        if ($this->_query != false) {
            if (@mysql_num_rows($this->_query) > 0) {
                $row = mysql_fetch_assoc($this->_query);
                $this->_query = false;
                return array(true,$row);
            }
        }
        return array(false,"getResult()");
    }

    /*
     * Returns the selected object or null on failure
     */

    public function getObject() {
        if (mysql_num_rows($this->_query) > 0) {
            $result = mysql_fetch_object($this->_query, $this->_class);
            $this->_query = false;
            array_walk($result, 'utf8_encode_array');
            return $result;
        }
        else
            return null;
    }

    /*
     * Returns one or more objects in array form
     * 
     */

    public function getObjectArray() {
        if (mysql_num_rows($this->_query) > 0) {
            $result = array();
            while ($row = mysql_fetch_object($this->_query, $this->_class)){
                $result[] = $row;
            }
            $this->_query = false;
            array_walk($result, 'utf8_encode_array');
            return $result;
        }
        else
            return null;
    }


    /*
     * Stores the object state in the dabase.
     * Previously retrieves the keys-values pair and then inserts information onto the db
     */
    public function store($object) {

        $i = 0;
        $values = '';
        $fields = '';
        foreach ($object as $k => $val) {
            if (!($this->_is_an_autoincrement_key && $k == $this->_key) && substr($k, 0, 1) != '_') {
                if ($i == 0) {
                    $fields = '`' . $k . '`';
                    $values = '\'' . $val . '\'';
                } else {
                    $fields.=', `' . $k . '`';
                    $values.=', \'' . $val . '\'';
                }
                $i++;
            }
        }

        $query = 'INSERT INTO ' . $this->_table . ' (' . $fields . ') VALUES (' . $values . ')';
        $return = $this->makeQuery($query);
        //~ if ($this->_is_an_autoincrement_key) {
            //~ $query = 'SELECT LAST_INSERT_ID() AS id';
            //~ $this->makeQuery($query);
            //~ $result = $this->getResult();
            //~ return array(true,$result['id']);
        //~ } else {
            return array(true,$return);
        //~ }
    }

    /*loads an object (entity)*/
    public function load($k) {
        $query = 'SELECT * ' .
                'FROM `' . $this->_table . '` ' .
                'WHERE `' . $this->_key . '` = "' . $k . '"';
        $r = $this->makeQuery($query);
        if($r[0])
            return $this->getObject();
        else
            return false;
    }

    /*deletes an entity*/
    public function delete(& $object) {
        $arrayObject = get_object_vars($object);
        $query = 'DELETE ' .
                'FROM `' . $this->_table . '` ' .
                'WHERE `' . $this->_key . '` = \'' . $arrayObject[$this->_key] . '\'';
        unset($object);
        return array(true,$this->makeQuery($query));
    }

    /*updates the state of a given object*/
    public function update($object) {
        $i = 0;
        $fields = '';
        foreach ($object as $k => $val) {
            if (!($k == $this->_key) && substr($k, 0, 1) != '_') {
                if ($i == 0) {
                    $fields.='`' . $k . '` = \'' . $val . '\'';
                } else {
                    $fields.=', `' . $k . '` = \'' . $val . '\'';
                }
                $i++;
            }
        }
        $arrayObject = get_object_vars($object);
        $query = 'UPDATE `' . $this->_table . '` SET ' . $fields . ' WHERE `' . $this->_key . '` = \'' . $arrayObject[$this->_key] . '\'';
        return array(true,$this->makeQuery($query));
    }

    /*Search values using the "SELECT FROM WHERE ORDER BY LIMIT" statement*/
    function search($param = array(), $order = '', $limit = ''){
        $filtro = '';
        for ($i = 0; $i < count($param); $i++) {
            if ($i > 0)
                $filtro .= ' AND';
            $filtro .= ' `' . $param[$i][0] . '` ' . $param[$i][1] . ' \'' . $param[$i][2] . '\'';
        }
        $query = 'SELECT * ' .
                'FROM `' . $this->_table . '` ';
        if ($filtro != '')
            $query.='WHERE ' . $filtro . ' ';
        if ($order != '')
            $query.='ORDER BY ' . $order . ' ';
        if ($limit != '')
            $query.='LIMIT ' . $limit . ' ';
        $this->makeQuery($query);
        return $this->getObjectArray();
    }

    public function close() {

        try {

            $result = @mysql_close();
            if (!$result)
                throw new dbException("close()", false); else {

                $this->up = false;
                return array(true, "connection closed!");
            }
        } catch (dbException $ex) {

            return array($ex->getCode(), $ex->getMessage());
        }
    }

}

/*
 * Questa funzione codifica ricorsivamente in UTF-8 un array/oggetto,
 * per permettere l'invio di caratteri speciali tramite JSON.
 */
function utf8_encode_array (&$array, $key) {
    if(is_array($array) || is_object($array)) {
      array_walk ($array, 'utf8_encode_array');
    } else {
      $array = utf8_encode($array);
    }
}

?>
