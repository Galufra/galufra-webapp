<?php
require_once('FMysql.php');

class FUtente extends FMysql {

    public function __construct() {
        parent::__construct();
        $this->_table = 'utente';
        $this->_key = 'username';
        $this->_class = 'EUtente';
    }
    //faccio lo store dell' utente appena dopo la registrazione, evito la store per non registrare dei campi inutili
    public function storeUtente($user,$uid){
        $u = new EUtente();
        $u = $user;
        $query = 
        "INSERT INTO ".$this->_table." (username,password,email,citta,date,confirm_id)
            VALUES ('".$u->getUsername()."','".$u->getPassword()."','".$u->getEmail()."','".$u->getCitta()."','".date("d/m/Y - G:i")."','".$uid."')";
        $this->connect();
        $result = $this->makeQuery($query);
        return $result;
    }
    
    //Conferma la registrazione
    public function userConfirmation($uid){
        $this->connect();
        $query = "UPDATE $this->_table SET confirmed = 0 WHERE confirm_id = $uid";
        $result = $this->makeQuery($query);
        if($result[0] && mysql_num_rows($result[1])==1)
            return array(true,"Utente confermato");
        else
            return array(false,"Utente non confermato");
    }

}

?>
