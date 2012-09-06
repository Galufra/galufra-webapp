<?php
/**
 * @package Galufra
 */

/**
 * Classe che gestisce l'installazione dell'applicazione
 */
class Installer {
	private $step = 0;
	private $sql = 'galufra.sql';

	public function __construct(){
		echo '<html>
		<head>
		<title>Installazione Galufra-webapp</title>
		<link href="templates/template1/template/default.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
		<div id="content">';
		
		/* In base ai dati inviati via POST, determina il prossimo step
		 * dell'installazione.
		 */
		if (isset($_POST['dbuser']))
			$this->step = 1;
		if(isset($_POST['admin']))
			$this->step = 2;
			
		switch($this->step) {
			//Step 0: credenziali db
			case 0:
				$this->getDBInfo();
			break;
			//Step 1: creazione config, credenziali admin
			case 1:
				if(!$_POST['dbuser'] || !$_POST['dbpassword']){
					echo '<p>Non hai riempito tutti i campi richiesti!</p><br />
					<a href="./installer.class.php">Torna indietro</a>';
					exit();
				}
				
				
				$file = fopen('includes/config.inc.php', 'w+') 
					or die ('<p>Non hai permessi di scrittura in questa directory.</p><br/>
					<a href="./installer.class.php">Torna indietro</a>');
				$config = '<?php
	global $config;
	$config["mysql"] = array(
		"host" => "localhost",
		"username" => "'. $_POST['dbuser'].'",
		"password" => "'. $_POST['dbpassword'].'",
		"dbname" => "galufra");
	$config["smarty"] = array(
		"template_dir" => "../templates/template1/template/",
		"compile_dir" => "../templates/template1/templates_c/",
		"config_dir" => "../templates/template1/configs/",
		"cache_dir" => "../templates/template1/cache/",
	);
?>
';
				fwrite($file, $config);
				fclose($file);
					
				echo'<h3>File di configurazione pronto</h3>
				<p>Assicurati che il proprietario di includes/config.inc.php sia '. get_current_user()
				.' e imposta i permessi di includes/ e dei file in essa contenuti a 755 prima di proseguire.</p>' ;
				$this->getAdminInfo();
			break;
			//Step 2: popolamento del DB
			case 2:
				if ( $_POST['adminpassword'] != $_POST['adminpasswordconfirm'] ){
					echo 'Le password non corrispondono.';
					exit();
				}
				// Recuperiamo i dati forniti dall'admin poco fa
				require_once 'includes/config.inc.php';
				// Connessione al dbms e creazione del nuovo database
				mysql_connect($config['mysql']['host'],
					$config['mysql']['username'],
					$config['mysql']['password']);
				try {
					mysql_query('CREATE DATABASE IF NOT  EXISTS galufra');
					mysql_select_db('galufra');
					$this->importa_sql($this->sql);
					// Creazione del nuovo utente admin
					require_once 'Foundation/FUtente.php';
					require_once 'Entity/EUtente.php';
					$admin = new EUtente();
					$admin->setUsername($_POST['admin']);
					$admin->setPassword($_POST['adminpassword']);
					$admin->setEmail($_POST['adminmail']);
					$admin->sblocca();
					$admin->administrate();
					$admin->setSuperuser();
					$admin->setConfirmed(1);
					// Il nuovo utente viene aggiunto al db
					$store = new FUtente();
					$store->connect();
					$store->storeUtente($admin, 0);
					$store->update($admin);
					echo'<h3>Installazione completata!</h3>
					<p>Ricordati di <b>ELIMINARE QUESTO FILE E GALUFRA.SQL!</b></p><br>
					<a href="./Controller/CHome.php">Vai all\'applicazione</a>';
				}
				catch (Exception $e){
					echo'<h3>Errore nella creazione del DB</h3>';
					echo $e;
					echo '<p>Controlla che le credenziali siano corrette e riprova.</p>';
					mysql_query('DROP DATABASE galufra');
				}
				mysql_close();
		}
		echo '</div></body></html>';
		
	}

	/* Crea una form per ottenere le credenziali d'accesso al DB
	 */
	public function getDBInfo(){
		echo '<h2>Credenziali di accesso al database</h2>
                <p>Se hai precedentemente eseguito questa procedura vuol dire che hai dimenticato di <b>ELIMINARE</b> questo file e il file galufra.sql:
                eliminali e ritorna alla pagina index.html per avviare l\'applicazione correttamente</p>
		<p>Inserisci lo username e la password che verranno usati per la connessione al database.</p>
		<p>Assicurati che la directory includes/ e la directory template/template1/templates_c abbiano i permessi impostati a 777.</p>
			<form method="POST" action="installer.class.php">
			<label>Username:</label><input type="text" name="dbuser"/><br />
			<label>Password:</label><input type="password" name="dbpassword"/> <br />
			<button type="submit">Invia</button>
		</form>';
	}
	
	/* Form per le credenziali dell'amministratore del sito.
	 */
	public function getAdminInfo(){
		echo '<h2>Credenziali dell\'amministratore</h2>
		<p>Inserisci uno username e una password. Al termine dell\'installazione
		potrai usare queste credenziali per accedere all\'applicazione ed amministrarla.</p>
			<form method="POST" action="installer.class.php">
			<label>Username:</label><input type="text" name="admin"/><br />
			<label>E-Mail:</label><input type="text" name="adminmail"/><br />
			<label>Password:</label><input type="password" name="adminpassword"/> <br />
			<label>Conferma password:</label><input type="password" name="adminpasswordconfirm"/> <br />
			<button type="submit">Invia</button>
		</form>';
	}

	/* Legge un file .sql ed esegue le istruzioni che esso contiene
	 */
	public function importa_sql($sqlfile) {
		// estraggo il contenuto del file
		$queries = file_get_contents($sqlfile);
		// Rimuovo eventuali commenti
		$queries = preg_replace(array('/\/\*.*(\n)*.*(\*\/)?/', '/\s*--.*\n/', '/\s*#.*\n/'), "\n", $queries);
		// recupero le singole istruzioni
		$statements = explode(";\n", $queries);
		$statements = preg_replace("/\s/", ' ', $statements);
		// ciclo le istruzioni
		foreach ($statements as $query) {
			$query = trim($query);
			if ($query) {
				// eseguo la singola istruzione
				$result = mysql_query($query);
				// e stampo eventuali errori
				if (!$result)
					throw new Exception('Impossibile eseguire la query ' . $query . ': ' . mysql_error());
			}
		}
	}
}

$installer = New Installer();
?>
