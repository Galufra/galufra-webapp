<?php



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

    /**
     * @access public
     */
    function __construct() {
        $this->up = false;
    }

    /**
     * @access public
     * @global array $config
     * @return array
     *
     * Si connette al database
     */
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

    /**
     * @access public
     * @param string $query
     * @return array
     *
     * Si preoccupa di salvare una query
     */
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

    /**
     * @access public
     * @return array
     *
     * Fornisce i risultati di una query
     */

    public function getResult() {
        if ($this->_query != false) {
            if (@mysql_num_rows($this->_query) > 0) {
                $row = @mysql_fetch_assoc($this->_query);
                $this->_query = false;
                return array(true, $row);
            }
        }
        return array(false, "getResult()");
    }

    /**
     *
     *
     * @access public
     * @return Object
     *
     * Fornisce il risultato di una query che richiede un oggetto
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

    /**
     *
     *
     * @access public
     * @return array(Object)
     *
     * Fornisce il risultato di una query che richiede un array di oggetti
     */

    public function getObjectArray() {
        if (mysql_num_rows($this->_query) > 0) {
            $result = array();
            while ($row = mysql_fetch_object($this->_query, $this->_class)) {
                $result[] = $row;
            }
            $this->_query = false;
            array_walk($result, 'utf8_encode_array');
            return $result;
        }
        else
            return null;
    }


    /**
     * @access public
     * @param Object $object
     * @return array
     *
     * Si preoccupa di salvare un oggetto. Si prende le coppie campo-valore scorrendo
     * l'oggetto in questione come se fosse un array
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

        return array(true, $return);

    }

    /**
     * @access public
     * @param Key $k
     * @return Object
     *
     * Carica un'entità
     *
     */

    public function load($k) {
        $query = 'SELECT * ' .
                'FROM `' . $this->_table . '` ' .
                'WHERE `' . $this->_key . '` = "' . $k . '"';
        $r = $this->makeQuery($query);
        if ($r[0])
            return $this->getObject();
        else
            return false;
    }

    /**
     * @access public
     * @param Object $object
     * @return array
     *
     * Elimina un'entità
     */

    public function delete(& $object) {
        $arrayObject = get_object_vars($object);
        $query = 'DELETE ' .
                'FROM `' . $this->_table . '` ' .
                'WHERE `' . $this->_key . '` = \'' . $arrayObject[$this->_key] . '\'';
        unset($object);
        return array(true, $this->makeQuery($query));
    }

    /**
     * @access public
     * @param Object $object
     * @return array
     *
     * Fa l'update di un'entità
     */

    public function update($object) {
        $i = 0;
        $fields = '';
        foreach ($object as $k => $val) {
            if (!($k == $this->_key) && substr($k, 0, 1) != '_') {
                if ($i == 0) {
                    $fields.='`' . $k . '` = \'' . htmlspecialchars($val) . '\'';
                } else {
                    $fields.=', `' . $k . '` = \'' . htmlspecialchars($val) . '\'';
                }
                $i++;
            }
        }
        $arrayObject = get_object_vars($object);
        $query = 'UPDATE `' . $this->_table . '` SET ' . $fields . ' WHERE `' . $this->_key . '` = \'' . $arrayObject[$this->_key] . '\'';
        return array(true, $this->makeQuery($query));
    }

    /**
     * @access public
     * @param array $param
     * @param string $order
     * @param string $limit
     * @return array(Object)
     *
     * Esegue una query utilizzando i filtri forniti come parametro
     */
    

    function search($param = array(), $order = '', $limit = '') {
        $filtro = '';
        for ($i = 0; $i < count($param); $i++) {
            if ($i > 0)
                $filtro .= ' AND';
            $filtro .= ' `' . $param[$i][0] . '` ' . $param[$i][1] . ' \'' . $param[$i][2] . '\'';
        }
        $query = 'SELECT * ' .
                'FROM `' .$this->_table . '` ';
        if ($filtro != '')
            $query.='WHERE ' . $filtro . ' ';
        if ($order != '')
            $query.='ORDER BY ' . $order . ' ';
        if ($limit != '')
            $query.='LIMIT ' . $limit . ' ';
        $this->makeQuery($query);
        return $this->getObjectArray();
    }

    /**
     * @access public
     * @return array
     *
     * Chiude una connessione
     */
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

/**
 * @access public
 * @param array $array
 * @param int $key
 * 
 * Questa funzione codifica ricorsivamente in UTF-8 un array/oggetto,
 * per permettere l'invio di caratteri speciali tramite JSON.
 */

function utf8_encode_array(&$array, $key) {
    if (is_array($array) || is_object($array)) {
        array_walk($array, 'utf8_encode_array');
    } else {
        $array = utf8_encode($array);
    }
}

?>
