<?php


namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;


//historia
use PawelWikiBundle\Classes\StringDiff;

class WyswietlHistorieController extends Controller
{
	 use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; pobierzNazweBaze as protected;}

    public function WyswietlHistorieAction($tytul, $maxIloscHistori = 50)
    {
    	$repository = $this->pobierzRepository();
        $doctrine = $this->pobierzDoctrine();

        $bazaArtykulow = new BazaArtykulow( $repository, $doctrine);

        $historiaArray = $bazaArtykulow->odczytajHistorie($tytul);

        //odczytaj ciag histori 
        //kazda historia wskazuje na  poprzednia zgodnie z idPoprzedniej
        //zwroc poprzednia historia zapisz w array i wyswietl na stronie
        $i = $maxIloscHistori; //dla zabezpieczenia przed nieskonczona petla
        do {
            $historia = end($historiaArray);
            $idPoprzedniej = $historia->getIdPoprzedniej();
            $newhistoriaArray = $bazaArtykulow->pobierzHistorie($idPoprzedniej);
            $historiaArray = array_merge($historiaArray, $newhistoriaArray);
            $i-=1;
        } while($idPoprzedniej !=0 or $i<0); 

        return $this->WyswietlStroneHistoria($tytul, $historiaArray);
    }



    /**
    *Funkcja pokazuje stara wersje Artykulu
    *@param - $tytul - tytul artykulu, $idStarego - nr id sterej histori 
    */
    public function PokazStaraHistorieAction($tytul, $idStarejHistori, $maxIloscHistori = 50 )
    {
        $repository = $this->pobierzRepository();
        $doctrine = $this->pobierzDoctrine();

        $bazaArtykulow = new BazaArtykulow( $repository, $doctrine);

        //pobierz stary obiekt klasy artykul zawierajacy stary tekst artykulu
        $staryArtykul = $bazaArtykulow->pobierzStaryArtykul($tytul, $idStarejHistori); 

        return $this->WyswietlStroneHistoriaArtykulu($staryArtykul); 

    }

    private function WyswietlStroneHistoria($tytul, $historiaArray = array())
    {        
        return $this->render('PawelWikiBundle:Historia:wiki_historia_strona.html.twig', array('tytul' => $tytul, 'historiaArray' => $historiaArray));
    }   



    private function WyswietlStroneHistoriaArtykulu($artykul)
    {
        
        return $this->render('PawelWikiBundle:Historia:stary_artykul.html.twig', array('tytul' => $artykul->odczytajTytul(), 'artykul' => $artykul ));
    }   



}

