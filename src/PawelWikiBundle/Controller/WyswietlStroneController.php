<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WyswietlStroneController extends Controller
{
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
    
    function artykulEntintyIntoArray( $artykulEntity )
    {
        // var_dump($artykulEntity);
        // exit();
        $artykulObject["id"] = $artykulEntity->getId(); 
        $artykulObject["tytul"] = $artykulEntity->getTytul();
        $artykulObject["tresc"] = $artykulEntity->getArtykul();
        $artykulObject["dataZmiany"] = $artykulEntity->getDataZmiany();
        $artykulObject["idHistori"] = $artykulEntity->getIdHistori();   

        return $artykulObject;     
    }

    function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function odczytajArtykul($tytul)
    {
    /*****************************************
    //Pobierz artykul o nazwie i zwroc obiekt
    ******************************************/
        $artykulEntity = $this->repository
                        ->findOneBy(array('tytul' => $tytul));


        if (!$artykulEntity) 
        {
            throw $this->createNotFoundException(
                'Nie znaleziono tytulu '.$tytul
            );
        }


        $artykulArray = $this->artykulEntintyIntoArray( $artykulEntity );

        $artykul = new Artykul( $artykulArray );

        return($artykul);
    }

}

class Artykul implements ArtykulInterface
{

    private $id;
    private $tytul;
    private $tresc;
    private $dataZmiany;
    private $idHistori;
    function __construct($artykulObject)
    {
        $this->id = $artykulObject["id"];
        $this->tytul = $artykulObject["tytul"];
        $this->tresc = $artykulObject["tresc"];
        $this->dataZmiany = $artykulObject["dataZmiany"];
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
        return $this->dataZmiany;
    }

    public function pobierzLinkDoHistori()
    {
        return $this->idHistori;
    }    

}

interface ArtykulInterface 
{
    public function odczytajID();
    public function odczytajTytul();
    public function odczytajTresc();
    public function odczytajDateUtworzenia();
    public function pobierzLinkDoHistori();
}