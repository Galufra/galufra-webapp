<?php

class EEvento{
	private $id_evento = null;
	private $nome = null;
	private $descrizione = null;
	private $data = null;
	private $n_visite = null;
	private $n_iscritti = null;
	private $gestore = null;
	private $locale = null;

	public function getIdEvento(){
		return $this->id_evento;
	}

	public function setIdEvento($idEvento){
		$this->id_evento = $idEvento;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getDescrizione(){
		return $this->descrizione;
	}

	public function setDescrizione($descrizione){
		$this->descrizione = $descrizione;
	}

	public function getData(){
		return $this->data;
	}

	public function setData($data){
		$this->data = $data;
	}

	public function getNVisite(){
		return $this->n_visite;
	}

	public function setNVisite($nVisite){
		$this->n_visite = $nVisite;
	}

	public function getNIscritti(){
		return $this->n_iscritti;
	}

	public function setNIscritti($nIscritti){
		$this->n_iscritti = $nIscritti;
	}

	public function getGestore(){
		return $this->gestore;
	}

	public function setGestore($gestore){
		$this->gestore = $gestore;
	}

	public function getLocale(){
		return $this->locale;
	}

	public function setLocale($locale){
		$this->locale = $locale;
	}
}

?>
