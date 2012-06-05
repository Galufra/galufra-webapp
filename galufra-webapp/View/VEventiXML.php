<?php
class VEventiXML{
    public function __construct($ev_array){
        $domtree = new DOMDocument('1.0', 'UTF-8');
		$xmlRoot = $domtree->createElement("xml");
        $xmlRoot = $domtree->appendChild($xmlRoot);
        foreach ($ev_array as $evento){
			$xmlEvento = $domtree->createElement("evento");
			$xmlEvento = $xmlRoot->appendChild($xmlEvento);
            $xmlEvento->appendChild(
				$domtree->createElement('id', $evento->getIdEvento())
			);
			$xmlEvento->appendChild(
				$domtree->createElement('nome', $evento->getNome())
			);
            $xmlEvento->appendChild(
				$domtree->createElement(
                    'descrizione', 
                    substr($evento->getDescrizione(), 0, 120).'...')
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
