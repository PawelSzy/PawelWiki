<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\Artykul;

use PawelWikiBundle\Entity\ArtykulDB;

/**
* 
*/
class ArtykulFactory extends Controller
{
    /***************************************************
    *Funkcja zwraca artykulu pozwala na zapis i odczyt
    ***************************************************/
    
    function __construct($repository, $doctrine)
    {
        $this->repository = $repository;
        $this->doctrine = $doctrine;
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
        $artykul = $this->nowyArtykul( $artykulArray );
        return $artykul;
    }

    public function nowyArtykul( $artykulArray )
    {
       //utworz nowy Artykul z podanego tytulu i tekstu 
        $artykul = new Artykul( $artykulArray );
        return $artykul; 

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

    private function artykulIntoEntinyDB( $artykul ) 
    {
        //zamienia artykul w entity do zapisanie w bazie danych
        $artykulEntity = new ArtykulDB;
        $artykulEntity->setTytul( $artykul->odczytajTytul() );
        $artykulEntity->setArtykul( $artykul->odczytajTresc() );
        $artykulEntity->setIdHistori( 0 );
        return $artykulEntity;

    }

    public function zapiszArtykul( $artykul )
    {
        $artykulEntity = $this->artykulIntoEntinyDB( $artykul );

        //zapisz do bazy danych
        $em = $this->doctrine->getManager();
        $em->persist($artykulEntity);
        $em->flush();

        $newArrayArtykul = $this->artykulEntintyIntoArray( $artykulEntity ); 
        return $this->nowyArtykul( $newArrayArtykul);

    }
}
