<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WyswietlStroneController extends Controller
{


    // function __construct()
    // {
    //     //parent::__construct();
    //     $this->repository = $this->getDoctrine()->getRepository('PawelWikiBundle:ArtykulDB:ArtykulDB');
    //     $this->ArtykulFactory = new ArtykulFactory($this->repository);

    // }


    public function WyswietlStroneAction($tytul)
    {
	echo "tytul: ".$tytul."\n";

    $this->repository = $this->getDoctrine()->getRepository('PawelWikiBundle:ArtykulDB:ArtykulDB');
    $this->ArtykulFactory = new ArtykulFactory($this->repository);

    $artykul = $this->ArtykulFactory->odczytajArtykul($tytul); 


    var_dump($artykul);
    return $this->render('PawelWikiBundle:Default:index.html.twig', array('name' => $tytul));

    // ... do something, like pass the $product object into a template
    }
}


/**
* 
*/
class ArtykulFactory extends Controller
{
    /***************************************************
    *Funkcja zwraca artykulu pozwala na zapis i odczyt
    ***************************************************/
    
    function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function odczytajArtykul($tytul)
    {
    /*****************************************
    //Pobierz artykul o nazwie i zwroc obiekt
    ******************************************/
        $artykul = $this->repository
                        ->findOneBy(array('tytul' => $tytul));


        if (!$artykul) 
        {
            throw $this->createNotFoundException(
                'Nie znaleziono tytulu '.$tytul
            );
        }
        return($artykul);
    }

}