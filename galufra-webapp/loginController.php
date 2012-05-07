<?
/* Credo che dovremmo mettere queste istruzioni in un metodo
 * della classe entità session...
 */

$u = new FUtente();
/* Carico le informazioni dell'utente specificato. FUtente dovrebbe darci
 * modo di capire se il caricamento non è andato a buon fine, ad esempio
 * restituendo false. In tal caso faremmo:
 * if ($utente = $u->loadUsername($_POST['username'])){
 *  ... creo una nuova sessione 
 * }
 * else errore;
 */
$utente = $u->loadUsername($_POST['username']);
if (md5($_POST['password']) == $utente->getPassword()){
    $s = new session();
    $s->setStatus($utente->getId);
}
else {
    
}

?>
