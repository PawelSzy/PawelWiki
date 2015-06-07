<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\Artykul;

use PawelWikiBundle\Controller\MyHellpers;

use PawelWikiBundle\Entity\ArtykulDB;



/**
* 
*/
class BazaArtykulow extends Controller
{
    /***************************************************
    *Funkcja zwraca artykulu pozwala na zapis i odczyt
    ***************************************************/
 use PobierzRepositoryTrait { pobierzAdresBazyDanych as protected;}    
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
        $artykulEntity = $this->pobierzArtykulEntity( $tytul );
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
        //pozbadz sie spacji z tytulu
        $tytul = MyHellpers::zamienSpacjeNaPodkreslenia( $artykulArray['tytul'] );
        echo $tytul;
       $artykulArray['tytul'] = $tytul;
       //zwraca instacje klassy Artykul z podanego tytulu i tekstu l
        $artykul = new Artykul( $artykulArray );
        return $artykul; 

    }


    public function zapiszNowyArtykul( $artykul )
    {
        //zapisuje informacje z objectu o klasie Artykul w bazie danych
        $artykulEntity = $this->artykulIntoEntinyDB( $artykul );

        //zapisz do bazy danych
        $em = $this->doctrine->getManager();
        if ( $this->czyIstniejeTytul( $artykul->odczytajTytul() )){
            return Null;
       }
        $em->persist($artykulEntity);
        $em->flush(); 
        $newArrayArtykul = $this->artykulEntintyIntoArray( $artykulEntity ); 
        return $this->nowyArtykul( $newArrayArtykul);

    }


    public function edytujArtykul( $artykul )
    {
        $tytul = $artykul->odczytajTytul();
        $tresc = $artykul->odczytajTresc();

        if( $this->czyIstniejeTytul( $tytul ))
        {
            //modyfikacja istniejacego artykulu
            $artykulEntity = $this->pobierzArtykulEntity( $tytul );
            $artykulEntity->setTytul( $tytul );
            $artykulEntity->setArtykul( $tresc );
            //zapisz do bazy danych
            $em = $this->doctrine->getManager();
            $em->persist($artykulEntity);
            $em->flush(); 
            $newArrayArtykul = $this->artykulEntintyIntoArray( $artykulEntity ); 
            return $this->nowyArtykul( $newArrayArtykul);
        }
        else
        {
            return $this->zapiszNowyArtykul( $artykul );
        }        

    }

    public function skasujArtykul( $tytul )
    {
        $artykulEntity = $this->pobierzArtykulEntity( $tytul );

        //kasowanie
        $em = $this->doctrine->getManager();
        $em->remove($artykulEntity);
        $em->flush(); 
        
        return True;

    }

    public function czyIstniejeTytul( $tytul )
    {
    /////////////////////////////
    //Funkcja zwraca True jesli istnieje artykul o podanej nazwie a bazie danyc
    //zwraca false jesli nie istnieje artykul
    ///////////////////////////
        //$product = $entityManager->find('Tytul', $tytul);
        $entityManager = $this->doctrine->getManager();
        $adres_bazy = $this->pobierzAdresBazyDanych();
        $dql = "SELECT ArtykulDB FROM ".$adres_bazy.' ArtykulDB WHERE ArtykulDB.tytul = :tytul';
        $query = $entityManager->createQuery($dql);
        $query->setParameter('tytul', $tytul);

        $res = $query->getResult();
        return !empty($res);
    }


    private function pobierzArtykulEntity( $tytul )
    {
    /*****************************************
    //Pobierz artykulEntuty z bazy danych
    ******************************************/
        $artykulEntity = $this->repository
                        ->findOneBy(array('tytul' => $tytul));

        if (!$artykulEntity) 
        {
            throw $this->createNotFoundException(
                'Nie znaleziono tytulu '.$tytul
            );
        }
        return $artykulEntity;       
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

}
