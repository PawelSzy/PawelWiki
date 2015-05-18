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

    //print_r($artykul);
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
        $artykulObject = $this->repository
                        ->findOneBy(array('tytul' => $tytul));


        if (!$artykulObject) 
        {
            throw $this->createNotFoundException(
                'Nie znaleziono tytulu '.$tytul
            );
        }

        $artykul = $artykulObject;
        //$artykul = new Artykul();

        return($artykul);
    }

}

class Artykul implements ArtykulInterface
{

    private $id;
    private $tytul;
    private $tresc;
    private $data;
    private $idHistori;
    function __construct($artykulObject)
    {
        $this->id = $artykulObject["id"];
        $this->tytul = $artykulObject["tytul"];
        $this->tresc = $artykulObject["tresc"];
        $this->data = $artykulObject["date"];
        $this->idHistory = $artykulObject["idHistori"];
    }


    public function odczytajID()
    {
        return $this->id;
    }

    public function odczytajTytul()
    {
        return $this->tytul;
    }

    public function odczytajTresc()
    {
        return $this->tresc;
    }    

    public function odczytajDateUtworzenia()
    {
        return $this->data;
    }

    public function pobierzLinkDoHistori()
    {
        return $this->idHistori;
    }    

    // public function var_dumpArtykul()
    // {
    //     echo $this->odczytajID()
    // }


}

interface ArtykulInterface 
{
    public function odczytajID();
    public function odczytajTytul();
    public function odczytajTresc();
    public function odczytajDateUtworzenia();
    public function pobierzLinkDoHistori();
}