<?php
/**
 * @package Galufra
 */

/**
 * View inutilizzata. Gestisce l'invio di eventi in formato XML.
 * È stata adottata la tecnologia Json in sostituzione di questa.
 */
class VEventiXML {

    /**
     * @access public
     *
     * Crea un XML con gli eventi che vogliamo stampare.
     *
     * L'utilizzo di Json è risultato più veloce e semplice
     *
     * @param array $ev_array
     *
     */
    public function __construct($ev_array) {
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $xmlRoot = $domtree->createElement("xml");
        $xmlRoot = $domtree->appendChild($xmlRoot);
        foreach ($ev_array as $evento) {
            $xmlEvento = $domtree->createElement("evento");
            $xmlEvento = $xmlRoot->appendChild($xmlEvento);
            $xmlEvento->appendChild(
                    $domtree->createElement('id', $evento->getIdEvento())
            );
            $xmlEvento->appendChild(
                    $domtree->createElement('nome', $evento->getNome())
            );
            $substr = substr($evento->getDescrizione(), 0, 120);
            if ($substr != $evento->getDescrizione())
                $substr .= '...';
            $xmlEvento->appendChild(
                    $domtree->createElement('descrizione', $substr)
            );
            $xmlEvento->appendChild(
                    $domtree->createElement('data', $evento->getData())
            );
            $xmlEvento->appendChild(
                    $domtree->createElement('lat', $evento->getLat())
            );
            $xmlEvento->appendChild(
                    $domtree->createElement('lon', $evento->getLon())
            );
        }
        echo $domtree->saveXML();
    }

}

?>
