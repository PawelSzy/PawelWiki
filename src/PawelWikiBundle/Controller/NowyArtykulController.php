<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\ArtykulFactory;

define('artykulRepository','PawelWikiBundle:ArtykulDB:ArtykulDB');

class NowyArtykulController extends Controller
{

    private function pobierzRepository()
    {
        $repository = $this->getDoctrine()->getRepository( artykulRepository );
        return $repository;
    }

    public function NowyArtykulAction( $tytul )
    {
    $repository = $this->pobierzRepository();
    
    $this->ArtykulFactory = new ArtykulFactory( $repository );
    $artykul = $this->ArtykulFactory->odczytajArtykul( $tytul ); 

    return $this->render( 'PawelWikiBundle:Default:artykul.html.twig', array('tytul' => $artykul->odczytajTytul(),
            'tresc' => $artykul->odczytajTresc()
        ));
    }
}