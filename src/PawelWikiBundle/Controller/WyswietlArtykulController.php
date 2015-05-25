<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\ArtykulFactory;

require_once('PobierzRepositoryTrait.php');

class WyswietlArtykulController extends Controller
{

    use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; }

    public function WyswietlArtykulAction( $tytul )
    {
    $repository = $this->pobierzRepository();
    $doctrine = $this->pobierzDoctrine();
    
    $this->ArtykulFactory = new ArtykulFactory( $repository, $doctrine );
    $artykul = $this->ArtykulFactory->odczytajArtykul( $tytul ); 

    return $this->render( 'PawelWikiBundle:Default:artykul.html.twig', array('tytul' => $artykul->odczytajTytul(),
            'tresc' => $artykul->odczytajTresc()
        ));
    }
}