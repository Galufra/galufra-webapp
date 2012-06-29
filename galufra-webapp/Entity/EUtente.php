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

	public function getId(){
		return $this->id_utente;
	}

	public function getUsername(){
		return $this->username;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function getPassword(){
		return $this->password;
	}

    /**
     * Codifica $password e la salva come attributo
     * @param string $password
     */
	public function setPassword($password){
		$this->password = md5($password);
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getCognome(){
		return $this->cognome;
	}

	public function setCognome($cognome){
		$this->cognome = $cognome;
	}

	public function getEmail(){
		return $this->email;
	}

    /**
     * Imposta l'email dopo averne verificato la correttezza
     */
	public function setEmail($email){
        /* FILTER_VALIDATE_EMAIL è un filtro di validazione
         * per indirizzi email. Restituisce true se $email
         * è un indirizzo corretto.
         */
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
            $this->email = $email;
        else
            throw new Exception('email non valida!');
	}

	public function getCitta(){
		return $this->citta;
	}

	public function setCitta($citta){
		$this->citta = $citta;
	}

	public function getConfirmed(){
		return $this->confirmed;
	}

	public function setConfirmed($confirmed){
		$this->confirmed = $confirmed;
	}

	public function getDate(){
		return $this->date;
	}

	public function getPermessi(){
		return $this->permessi;
	}

	public function setPermessi($permessi){
		$this->permessi = $permessi;
	}
    public function addPreferiti($evento){
        $ev = new FEvento();
        $ev->connect();
        $ev->storePreferiti($this->id_utente, $evento);
    }
    public function removePreferiti($evento){
        $ev = new FEvento();
        $ev->connect();
        $ev->removePreferiti($this->id_utente, $evento);
    }
}
?>
