<?php

namespace PawelWikiBundle\Controller\autor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\MyHellpers;

use PawelWikiBundle\Entity\AutorDB;



/**
* 
*/
class BazaAutorow
{
    /***************************************************
    *Funkcja zwraca artykulu pozwala na zapis i odczyt
    ***************************************************/
 // use RepositoryTraitAutorow { pobierzAdresBazyDanych as protected;}    
    function __construct($repository, $doctrine)
    {
        $this->repository = $repository;
        $this->doctrine = $doctrine;
    }

    public function odczytajAutora($login)
    {
    /*****************************************
    //Pobierz artykul o nazwie i zwroc obiekt
    ******************************************/
        $autorEntity = $this->pobierzAutorEntity( $login );
        if (!$autorEntity) 
        {
            throw $this->createNotFoundException(
                'Nie znaleziono tytulu '.$tytul
            );
        }

        // $artykulArray = $this->artykulEntintyIntoArray( $artykulEntity );
        // $artykul = $this->nowyArtykul( $artykulArray );
        return $autorEntity;
    }

    // public function nowyArtykul( $artykulArray )
    // {
    //     //@return fukcja zwraca nowy obiekt o klasie artykul
    //     //pozbadz sie spacji z tytulu
    //     $tytul = MyHellpers::zamienSpacjeNaPodkreslenia( $artykulArray['tytul'] );
    //    $artykulArray['tytul'] = $tytul;
    //    //zwraca instacje klassy Artykul z podanego tytulu i tekstu l
    //     $artykul = new Artykul( $artykulArray );
    //     return $artykul; 

    // }


    // public function zapiszNowyArtykul( $artykul )
    // {
    //     //zmien tytule spacje na podkreslenie 
    //     $tytul = $artykul->odczytajTytul();
    //     $nowy_tytul = MyHellpers::zamienSpacjeNaPodkreslenia( $tytul );
    //     $artykul->zmienTytul( $nowy_tytul );

    //     //zapisuje informacje z objectu o klasie Artykul w bazie danych
    //     $artykulEntity = $this->artykulIntoEntinyDB( $artykul );

    //     //zapisz do bazy danych
    //     $em = $this->doctrine->getManager();
    //     if ( $this->czyIstniejeTytul( $artykul->odczytajTytul() )){
    //         return Null;
    //    }
    //     $em->persist($artykulEntity);
    //     $em->flush(); 
    //     $newArrayArtykul = $this->artykulEntintyIntoArray( $artykulEntity ); 
    //     return $this->nowyArtykul( $newArrayArtykul);

    // }


    // public function edytujArtykul( $artykul )
    // {
    //     $tytul = $artykul->odczytajTytul();
    //     $tresc = $artykul->odczytajTresc();

    //     if( $this->czyIstniejeTytul( $tytul ))
    //     {
    //         //modyfikacja istniejacego artykulu
    //         $artykulEntity = $this->pobierzArtykulEntity( $tytul );
    //         $artykulEntity->setTytul( $tytul );
    //         $artykulEntity->setArtykul( $tresc );
    //         //zapisz do bazy danych
    //         $em = $this->doctrine->getManager();
    //         $em->persist($artykulEntity);
    //         $em->flush(); 
    //         $newArrayArtykul = $this->artykulEntintyIntoArray( $artykulEntity ); 
    //         return $this->nowyArtykul( $newArrayArtykul);
    //     }
    //     else
    //     {
    //         return $this->zapiszNowyArtykul( $artykul );
    //     }        

    // }

    // public function skasujArtykul( $tytul )
    // {
    //     $artykulEntity = $this->pobierzArtykulEntity( $tytul );

    //     //kasowanie
    //     $em = $this->doctrine->getManager();
    //     $em->remove($artykulEntity);
    //     $em->flush(); 
        
    //     return True;

    // }

    // public function czyIstniejeTytul( $tytul )
    // {
    // /////////////////////////////
    // //Funkcja zwraca True jesli istnieje artykul o podanej nazwie a bazie danyc
    // //zwraca false jesli nie istnieje artykul
    // ///////////////////////////
    //     //$product = $entityManager->find('Tytul', $tytul);
    //     $entityManager = $this->doctrine->getManager();
    //     $adres_bazy = $this->pobierzAdresBazyDanych();
    //     $dql = "SELECT ArtykulDB FROM ".$adres_bazy.' ArtykulDB WHERE ArtykulDB.tytul = :tytul';
    //     $query = $entityManager->createQuery($dql);
    //     $query->setParameter('tytul', $tytul);

    //     $res = $query->getResult();
    //     return !empty($res);
    // }


    private function pobierzAutorEntity( $login )
    {
    /*****************************************
    //Pobierz artykulEntuty z bazy danych
    ******************************************/
        $artykulEntity = $this->repository
                        ->findOneBy(array('login' => $login));

        if (!$artykulEntity) 
        {
            throw $this->createNotFoundException(
                'Nie znaleziono autora '.$login
            );
        }
        return $artykulEntity;       
    }

    // private function artykulEntintyIntoArray( $artykulEntity )
    // {
        
    //     $artykulObject["id"] = $artykulEntity->getId(); 
    //     $artykulObject["tytul"] = $artykulEntity->getTytul();
    //     $artykulObject["tresc"] = $artykulEntity->getArtykul();
    //     $artykulObject["dataZmiany"] = $artykulEntity->getDataZmiany();
    //     $artykulObject["idHistori"] = $artykulEntity->getIdHistori();   

    //     return $artykulObject;     
    // }

    // private function artykulIntoEntinyDB( $artykul ) 
    // {
    //     //zamienia artykul w entity do zapisanie w bazie danych
    //     $artykulEntity = new ArtykulDB;
    //     $artykulEntity->setTytul( $artykul->odczytajTytul() );
    //     $artykulEntity->setArtykul( $artykul->odczytajTresc() );
    //     $artykulEntity->setIdHistori( 0 );
    //     return $artykulEntity;

    // }

}
