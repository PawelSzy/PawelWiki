<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\ArtykulFactory;

// define('artykulRepository','PawelWikiBundle:ArtykulDB:ArtykulDB');
require_once('PobierzRepositoryTrait.php');

class WyswietlArtykulController extends Controller
{

    use PobierzRepositoryTrait { pobierzRepository as protected; }

    public function WyswietlArtykulAction( $tytul )
    {
    $repository = $this->pobierzRepository();
    
    $this->ArtykulFactory = new ArtykulFactory( $repository );
    $artykul = $this->ArtykulFactory->odczytajArtykul( $tytul ); 

    return $this->render( 'PawelWikiBundle:Default:artykul.html.twig', array('tytul' => $artykul->odczytajTytul(),
            'tresc' => $artykul->odczytajTresc()
        ));
    }
}