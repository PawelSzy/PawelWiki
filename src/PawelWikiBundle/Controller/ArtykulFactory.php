<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\Artykul;

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

    private function artykulEntintyIntoArray( $artykulEntity )
    {
        
        $artykulObject["id"] = $artykulEntity->getId(); 
        $artykulObject["tytul"] = $artykulEntity->getTytul();
        $artykulObject["tresc"] = $artykulEntity->getArtykul();
        $artykulObject["dataZmiany"] = $artykulEntity->getDataZmiany();
        $artykulObject["idHistori"] = $artykulEntity->getIdHistori();   

        return $artykulObject;     
    }
}
