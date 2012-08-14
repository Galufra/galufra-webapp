<?php

class EUtente {

    private $id_utente = null;
    public $username = null;
    public $password = null;
    public $nome = null;
    public $cognome = null;
    public $email = null;
    public $citta = null;
    private $confirmed = null;
    private $date = null;
    private $permessi = null;
    private $num_eventi = 0;
    public $sbloccato = 1;
    public $admin = 0;
    public $superuser = 0;

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

    public function administrate() {
        $this->admin = 1;
    }

    public function setSuperuser() {
        $this->superuser = 1;
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

    public function sblocca() {

        $this->sbloccato = 1;
    }

    public function blocca() {

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
            return false;
    }

    public function getCitta() {
        return $this->citta;
    }

    public function setCitta($citta) {
        $this->citta = $citta;
    }

    public function isConfirmed() {
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

        $this->num_eventi++;
        
        if ($this->num_eventi >= 3 && (!$this->isSuperuser() || !$this->isAdmin())) {
            $this->blocca();
        } else if ($this->num_eventi >= 20 && !$this->isAdmin()){
            $this->blocca();
        }else
            $this->sblocca ();


    }

    public function isSbloccato() {

        return $this->sbloccato;
    }

    public function isAdmin() {
        return $this->admin;
    }

    public function isSuperuser() {
        return $this->superuser;
    }

    public function addPreferiti($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->storePreferiti($this->id_utente, $evento);
    }

    public function addConsigliati($evento, $lat, $lon) {
        $ev = new FEvento();
        $ev->connect();
        $ev->storeConsigliati($this->id_utente, $evento, $lat, $lon);
    }

    public function removePreferiti($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->removePreferiti($this->id_utente, $evento);
    }

    public function removeConsigliati($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->removeConsigliati($this->id_utente, $evento);
    }

    public function setNumEventi($admin=0, $superuser=0) {

        $ev = new FEvento();
        $ev->connect();
        $result = $ev->userEventCounter($this->id_utente);

        $this->num_eventi = $result["COUNT(*)"];

        if ($this->num_eventi >= 3 && (!$admin && !$superuser )) {
            $this->blocca();
        } else if ($this->num_eventi >= 20 && ($superuser && !$admin)) {
            $this->blocca();
        } else {
            $this->sblocca();
        }
    }

    public function getEventi($id) {

        $ev = new FEvento();
        $ev->connect();
        return $ev->getUserEventi($id);
    }

}

?>
