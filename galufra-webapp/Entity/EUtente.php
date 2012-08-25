<?php
/**
 * @package Galufra
 */


/**
 * Entità Utente. Un utente può essere:
 * -normale
 * -superuser
 * -admin
 */
class EUtente {

    private $id_utente = null;
    public $username = null;
    public $password = null;
    public $nome = null;
    public $cognome = null;
    public $email = null;
    public $citta = null;
    public $confirmed = 0;
    private $date = null;
    private $num_eventi = 0;
    public $sbloccato = 1;
    public $admin = 0;
    public $superuser = 0;

    /**
     * @access public
     * @return int
     */
    public function getId() {
        return $this->id_utente;
    }

    /**
     * @access public
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @access public
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @access public
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @access public
     * Rende l'utente amministratore
     */
    public function administrate() {
        $this->admin = 1;
    }

    /**
     * @access public
     * rende l'utente superuser
     */
    public function setSuperuser() {
        $this->superuser = 1;
    }

    /**
     * @access public
     *
     * Codifica $password e la salva come attributo
     *
     * @param string $password
     *
     */
    public function setPassword($password) {
        $this->password = md5($password);
    }

    /**
     * @access public
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @access public
     * @param string $nome
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * @access public
     * @return string
     */
    public function getCognome() {
        return $this->cognome;
    }

    /**
     * @access public
     * @param string $cognome
     */
    public function setCognome($cognome) {
        $this->cognome = $cognome;
    }

    /**
     * @access public
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @access public
     * @return int
     */
    public function getNumEventi() {

        return $this->num_eventi;
    }

    /**
     * @access public
     *
     * sblocca il numero di eventi dell' utente
     */
    public function sblocca() {

        $this->sbloccato = 1;
    }

    /**
     * @access public
     *
     * blocca l'utente nel creare altri eventi
     *
     * @return boolean
     */
    public function blocca() {

        $this->sbloccato = 0;
        $ev = new FEvento();
        $ev->connect();
        return $ev->bloccaUtente($this->id_utente);
    }

    /**
     * @access public
     *
     * Imposta l'email dopo averne verificato la correttezza
     *
     * @param string $email
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

    /**
     * @access public
     * @return string
     */
    public function getCitta() {
        return $this->citta;
    }


    /**
     * @access public
     * @param string $citta
     */
    public function setCitta($citta) {
        $this->citta = $citta;
    }

    /**
     * @access public
     *
     * Dice se l'utente ha confermato la registrazione
     *
     * @return boolean
     */
    public function isConfirmed() {
        return $this->confirmed;
    }

    /**
     * @access public
     *
     * Fa un set dell' utente riguardo la conferma della registrazione
     *
     * @param boolean $confirmed
     */
    public function setConfirmed($confirmed) {
        $this->confirmed = $confirmed;
    }

    /**
     * @access public
     * @return string
     */
    public function getDate() {
        return $this->date;
    }


    /*public function getPermessi() {
        return $this->permessi;
    }

    public function setPermessi($permessi) {
        $this->permessi = $permessi;
    }*/

    /**
     * @access public
     *
     * Incrementa il numero degli eventi dell'utente controllando
     * se sia admin , superuser o utente semplice. Per ogni categoria svolge
     * un azione diversa
     */
    public function incrementaNumEventi() {

        $this->num_eventi++;
        
        if ($this->num_eventi >= 3 && (!$this->isSuperuser() || !$this->isAdmin())) {
            $this->blocca();
        } else if ($this->num_eventi >= 20 && !$this->isAdmin()){
            $this->blocca();
        }else
            $this->sblocca ();


    }

    /**
     * @access public
     * @return boolean
     */
    public function isSbloccato() {

        return $this->sbloccato;
    }

    /**
     * @access public
     * @return boolean
     */
    public function isAdmin() {
        return $this->admin;
    }

    /**
     * @access public
     * @return boolean
     */
    public function isSuperuser() {
        return $this->superuser;
    }

    /**
     * @access public
     *
     * Aggiunge un evento tra i preferiti dell'utente
     * usando FEvento::storePreferiti
     *
     * @param  int $evento
     */
    public function addPreferiti($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->storePreferiti($this->id_utente, $evento);
    }

    /**
     * @access public
     * Aggiunge un evento tra i consigliati
     * usando FEvento::addConsigliati
     *
     * @param int $evento
     *
     */
    public function addConsigliati($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->storeConsigliati($this->id_utente, $evento);
    }

    /**
     * @access public
     * 
     * Rimuove un evento tra i preferiti usando FEvento::removePreferiti
     *
     * @param int $evento
     */
    public function removePreferiti($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->removePreferiti($this->id_utente, $evento);
    }

    /**
     * @access public
     *
     * Rimuove un evento dai consigliati usando
     * FEvento::removeConsigliati
     *
     * @param int $evento
     */
    public function removeConsigliati($evento) {
        $ev = new FEvento();
        $ev->connect();
        $ev->removeConsigliati($this->id_utente, $evento);
    }

    /**
     * @access public
     *
     * Carica il numero degli eventi creato dall'utente
     * e si preoccupa nel caso di bloccarlo, sempre a seconda dei permessi
     *
     * @param boolean $admin
     * @param boolean $superuser
     *
     */
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

    /**
     *
     * @access public
     *
     * Fornisce il numero degli eventi personali dell' utente
     * usando FEvento::getUserEventi
     *
     * @param int $id
     * @return int
     */
    public function getEventi($id) {

        $ev = new FEvento();
        $ev->connect();
        return $ev->getUserEventi($id);
    }
}

?>
