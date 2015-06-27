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

    private function WyswietlStroneHistoria($tytul, $historiaArray = array())
    {        
        return $this->render('PawelWikiBundle:Default:wiki_historia_strona.html.twig', array('tytul' => $tytul, 'historiaArray' => $historiaArray));
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

        //pobierz aktualna wersje artykulu
        $artykul = $bazaArtykulow->odczytajArtykul($tytul);  
        $idHistori = $artykul->pobierzIDHistori();
        $tekstArtykulu = $artykul->odczytajTresc();
        var_dump($tekstArtykulu);

        $i = $maxIloscHistori; //dla zabezpieczenia przed nieskonczona petla
        while($idHistori != $idStarejHistori and $idHistori != 0)
        {
            $historia = $bazaArtykulow->pobierzHistorie($idHistori)[0] ;

            //dokonaj konwersji na stara wersje - stary tekst artykulu
            $diff =$historia->getArrayDiff();
            $tekstArtykulu =  StringDiff::zwrocStaryString($diff, $tekstArtykulu);

            //ustaw idHistori nastepnej wersji historii
            $idHistori = $historia->getIdPoprzedniej();

            $i-=1;
            if( $i<=0 ) {break;}
        }   
        var_dump($tekstArtykulu);  
        exit;
        return; 

    }



}

