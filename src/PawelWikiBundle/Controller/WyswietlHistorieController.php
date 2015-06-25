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

        $bazaArtykulow->odczytajHistorie($tytul);

        return $this->WyswietlStroneHistoria($tytul);
    }
    private function WyswietlStroneHistoria($tytul)
    {        
        return $this->render('PawelWikiBundle:Default:wiki_historia_strona.html.twig', array('tytul' => $tytul));
    }   

}

