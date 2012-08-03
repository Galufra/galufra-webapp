<?php

class EUtente {

    private $id_utente = null;
    private $username = null;
    private $password = null;
    private $nome = null;
    private $cognome = null;
    private $email = null;
    private $citta = null;
    private $confirmed = null;
    private $date = null;
    private $permessi = null;
    private $num_eventi = 0;
    private $sbloccato = 1;

    public function getId() {
        return $this->id_utente;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    /**
     * Codifica $password e la salva come attributo
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = md5($password);
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function setCognome($cognome) {
        $this->cognome = $cognome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNumEventi() {

        return $this->num_eventi;
    }

    public function sblocca(){

        $this->sbloccato = 1;

    }

    public function blocca(){

        $this->sbloccato = 0;
        $ev = new FEvento();
        $ev->connect();
        return $ev->bloccaUtente($this->id_utente);
    }

    /**
     * Imposta l'email dopo averne verificato la correttezza
     */
    public function setEmail($email) {
        /* FILTER_VALIDATE_EMAIL è un filtro di validazione
         * per indirizzi email. Restituisce true se $email
         * è un indirizzo corretto.
         */
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
            return true;
        }
        else
            throw new Exception('email non valida!');
    }

    public function getCitta() {
        return $this->citta;
    }

    public function setCitta($citta) {
        $this->citta = $citta;
    }

    public function getConfirmed() {
        return $this->confirmed;
    }

    public function setConfirmed($confirmed) {
        $this->confirmed = $confirmed;
    }

    public function getDate() {
        return $this->date;
    }

    public function getPermessi() {
        return $this->permessi;
    }

    public function setPermessi($permessi) {
        $this->permessi = $permessi;
    }

    public function incrementaNumEventi() {

        if ($this->num_eventi < 3) {
            $this->num_eventi++;
            return true;
        } else if ($this->num_eventi >= 3 && $this->sbloccato) {
            $this->num_eventi++;
            return true;
        }else
            $this->blocca ();

        return false;
    }
    
    public function isSbloccato(){
        
        return $this->sbloccato;
        
    }

    public function addPreferiti($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->storePreferiti($this->id_utente, $evento);
    }

    public function removePreferiti($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->removePreferiti($this->id_utente, $evento);
    }

    public function setNumEventi(){

        $ev = new FEvento();
        $ev->connect();
        $result = $ev->userEventCounter($this->id_utente);
        $this->num_eventi = $result["COUNT(*)"];
        if($this->num_eventi >= 3)
                $this->blocca ();

    }


}

?>
