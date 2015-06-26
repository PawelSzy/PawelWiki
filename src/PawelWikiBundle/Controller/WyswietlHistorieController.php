<?php


namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;

class WyswietlHistorieController extends Controller
{
	 use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; pobierzNazweBaze as protected;}

    public function WyswietlHistorieAction($tytul)
    {
    	$repository = $this->pobierzRepository();
        $doctrine = $this->pobierzDoctrine();

        $bazaArtykulow = new BazaArtykulow( $repository, $doctrine);

        $historiaArray = $bazaArtykulow->odczytajHistorie($tytul);

        //odczytaj ciag histori 
        //kazda historia wskazuje na  poprzednia zgodnie z idPoprzedniej
        //zwroc poprzednia historia zapisz w array i wyswietl na stronie
        $i = 50;
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



}

