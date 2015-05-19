<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\ArtykulFactory;

define('artykulRepository','PawelWikiBundle:ArtykulDB:ArtykulDB');

//require 'Symfony\PawelWiki\src\PawelWikiBundle\Controller\ArtykulFactory.php';

class WyswietlStroneController extends Controller
{
    public function WyswietlStroneAction($tytul)
    {
	echo "tytul: ".$tytul."\n";

    $this->repository = $this->getDoctrine()->getRepository(artykulRepository);
    
    $this->ArtykulFactory = new ArtykulFactory($this->repository);
    $artykul = $this->ArtykulFactory->odczytajArtykul($tytul); 


    var_dump($artykul);
    echo "***********".$artykul->odczytajTytul()."*******************************";
    return $this->render('PawelWikiBundle:Default:index.html.twig', array('name' => $tytul));
    }
}
