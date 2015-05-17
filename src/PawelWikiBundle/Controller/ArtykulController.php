<?php

namespace PawelWikiBundle\Controller;
//namespace Symfony\PawelWiki\src\PawelWikiBundle\Classes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArtykulController extends Controller
{
/*****************************************
//Obsluga Artykulu - wyswietl, zapisz itp
// podajemy tytul artykulu w URL
******************************************/

public function __construct($entityManager) {
    $this->entityManager = $entityManager;
}
    public function zwrocArtykul($tytul)
    {
	/*****************************************
	//Pobierz artykul o nazwie i zwroc obiekt
	******************************************/
	    $artykul = $this->getDoctrine()->getRepository('PawelWikiBundle:ArtykulDB:ArtykulDB')
	    				->findOneBy(array('tytul' => $tytul));


	    if (!$artykul) 
	    {
	        throw $this->createNotFoundException(
	            'Nie znaleziono tytulu '.$tytul
	        );
	    }
	    return($artykulu);
    }
}    