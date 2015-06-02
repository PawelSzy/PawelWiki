<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;

class WyswietlArtykulController extends Controller
{

    use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; pobierzNazweBaze as protected;}

    public function WyswietlArtykulAction( $tytul )
    {
    $repository = $this->pobierzRepository();
    $doctrine = $this->pobierzDoctrine();

    $this->BazaArtykulow = new BazaArtykulow( $repository, $doctrine );
    $artykul = $this->BazaArtykulow->odczytajArtykul( $tytul );

    return $this->wyswietlArtykul( $artykul );
    }


    public function SkasujArtykulAction( $tytul )
    {
        $BazaArtykulow = new BazaArtykulow( $this->pobierzRepository(), $this->pobierzDoctrine() );
        $BazaArtykulow->skasujArtykul( $tytul );
        $wiadomosc ="Skasowano artykul o nazwie: ".$tytul;
        $tytul_strony = "PawelWiki Skasowano strone";
        return $this->wyswietlWiadomosc( $wiadomosc, $tytul_strony);
    }
    

    private function wyswietlArtykul( $artykul )
    {
        return $this->render( 'PawelWikiBundle:Default:artykul.html.twig', array('tytul' => $artykul->odczytajTytul(),
            'tresc' => $artykul->odczytajTresc() )) ;        
    }

    private function wyswietlWiadomosc( $wiadomosc, $tytul_strony = "PawelWiki Wiadomosc")
    {
        return $this->render( 'PawelWikiBundle:Default:wiadomosc.html.twig', array('wiadomosc' => $wiadomosc,
            'tytul' => $tytul_strony));
    }

}