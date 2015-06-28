<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\BazaArtykulow;

use Symfony\Component\Routing\Generator\UrlGenerator;

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

    return $this->wyswietlArtykulNoEscaping( $artykul );
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
        $router = $this->get('router');
        $artykul->zapiszRouter($router);   
        return $this->render( 'PawelWikiBundle:Default:artykul.html.twig', array('tytul' => $artykul->odczytajTytul(),
            'artykul' => $artykul )) ;        
    }


    private function wyswietlArtykulNoEscaping( $artykul )
    {
        ////////////////////////////////////////////////
        // Wyswietl artykul na stronie 
        // funkcja dokonuje konwersji tresc z WikiCode do czystego HTML
        //@param obiekt klasy artykul
        //@return wyswietlona strona
        //////////////////////////////////////////////       

        //jedyne miejsce w programie gdzie moge przekazac HTML (z bazy danych) bez escaping do wyswietlania
        //na stronie
        $router = $this->get('router');
        $trescHTML = $artykul->zwrocHTML( $router );

  
        //var_dump($router->generate("pawel_wiki_artykul", array("tytul" => "Sapkowski4"), true) );
        return $this->render( 'PawelWikiBundle:Default:artykul_bez_escaping.html.twig', array('tytul' => $artykul->odczytajTytul(),
            'tresc' =>  $trescHTML  )) ;        
    }    

    private function wyswietlWiadomosc( $wiadomosc, $tytul_strony = "PawelWiki Wiadomosc")
    {
        return $this->render( 'PawelWikiBundle:Default:wiadomosc.html.twig', array('wiadomosc' => $wiadomosc,
            'tytul' => $tytul_strony));
    }

}