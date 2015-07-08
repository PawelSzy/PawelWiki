<?php

namespace PawelWikiBundle\Controller;
//namespace PawelWikiBundle\Classes;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\Artykul;

use PawelWikiBundle\Controller\MyHellpers;

use PawelWikiBundle\Entity\ArtykulDB;




//historia
use PawelWikiBundle\Entity\HistoriaDB;
use PawelWikiBundle\Classes\StringDiff;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;



use PawelWikiBundle\Controller\PasekLogowania;


/**
* 
*/
class BazaArtykulow extends Controller
{
    /***************************************************
    *Funkcja zwraca artykulu pozwala na zapis i odczyt
    ***************************************************/
 use PobierzRepositoryTrait { pobierzAdresBazyDanych as protected; pobierzAdresBazyHistori as protected;}  
     /**
    *Funkcja konstruktor - tworzy nowa instancje klasy BazaArtykulow
    *@param - $repository, $doctrine do odczytywania danych z bazy danych, $user - nazwa zalogowanego uzytkownika
    */  
    function __construct($repository, $doctrine, $user ="anon")
    {
        $this->repository = $repository;
        $this->doctrine = $doctrine;

        $this->user = $user;
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
        //@return fukcja zwraca nowy obiekt o klasie artykul
        //pozbadz sie spacji z tytulu
        $tytul = MyHellpers::zamienSpacjeNaPodkreslenia( $artykulArray['tytul'] );
       $artykulArray['tytul'] = $tytul;
       //zwraca instacje klassy Artykul z podanego tytulu i tekstu l
        $artykul = new Artykul( $artykulArray );
        return $artykul; 

    }


    public function zapiszNowyArtykul( $artykul )
    {
        //zmien tytule spacje na podkreslenie 
        $tytul = $artykul->odczytajTytul();
        $nowy_tytul = MyHellpers::zamienSpacjeNaPodkreslenia( $tytul );
        $artykul->zmienTytul( $nowy_tytul );



        ///////////////////////////////////////
        //zapisz do bazy danych
        ///////////////////////////////////////
        $em = $this->doctrine->getManager();
        if ( $this->czyIstniejeTytul( $artykul->odczytajTytul() )){
            return Null;
       }

        //zapisz w histori artykulu
        $idHistori = $this->utworzNowaHistorie( $artykul );

        //zapisz id Historii
        $artykul->zmienIDHistori($idHistori); 

        //zapisuje informacje z objectu o klasie Artykul w bazie danych
        $artykulEntity = $this->artykulIntoEntinyDB( $artykul );

        //zapis do bazy danych
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


            //zapisz w histori artykulu - $idHistori powienien byc idHistori poprzedniej modyfikacji
            $idHistori = $this->edytujHistoria( $artykul );

            //zapisz id Historii
            $artykul->zmienIDHistori($idHistori);


            //modyfikacja istniejacego artykulu
            $artykulEntity = $this->pobierzArtykulEntity( $tytul );
            $artykulEntity->setTytul( $tytul );
            $artykulEntity->setArtykul( $tresc );
            $artykulEntity->setIdHistori($idHistori);
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


    public function pobierzNajnowszeArtykulu( $iloscArtykulow = 5)
    {
         //$product = $entityManager->find('Tytul', $tytul);
        $entityManager = $this->doctrine->getManager();
        $adres_bazy = $this->pobierzAdresBazyDanych();
        $dql = "SELECT ArtykulDB FROM ".$adres_bazy.' ArtykulDB ORDER BY ArtykulDB.dataZmiany DESC';
        $query = $entityManager->createQuery($dql);
        // $query->setParameter('iloscArtykulow', $iloscArtykulow);
        $query->setMaxResults($iloscArtykulow);
        $najnowszeArt = $query->getResult();

        $artykuly = $this->zamienArrayEntityNaArtykuly( $najnowszeArt);

        return $artykuly;      
    }

    /**
    *zamiana array pobranego z bazy danych na obiekty typu artykul
    *@param array zawierajacy obiekty classy ArtykulDB - array entity pobrane z bazy danych 
    *@return array zawierajacy obiekty classy Artykul
    */
    private function zamienArrayEntityNaArtykuly( $arrayArtykul)
    {
         $artykuly = array();
        foreach ($arrayArtykul as $key => $artykul) {
            $artykulArray = $this->artykulEntintyIntoArray($artykul);
            $artykulObject = $this->nowyArtykul( $artykulArray );
            array_push( $artykuly,  $artykulObject );
        }

        return $artykuly;        
    }

    /**
    *Funkcja zwraca skroty najnowszych artykulow pierwsz 100 znakow
    */
    public function pobierzSkrotyNowychArtykulow($iloscArtykulow = 5)
    {
        $najnowszeArt = $this->pobierzNajnowszeArtykulu( $iloscArtykulow = 5, $iloscPierwszychZnakow = 400);
        foreach ($najnowszeArt as $key => $artykul) {
            $nowaTresc = $artykul->odczytajTresc();
            $nowaTresc = mb_substr($nowaTresc, 0, $iloscPierwszychZnakow);
            $artykul->zmienTresc($nowaTresc);

        }
        return $najnowszeArt;
    }


    public function szukajWBazieDanych($szukaj, $iloscArtykulow = 10)
    {

        $entityManager = $this->doctrine->getManager();
        $connection = $entityManager->getConnection();

        $sql = "SELECT * FROM `artykuldb` WHERE match(artykul) against( '".$szukaj."' IN BOOLEAN MODE) LIMIT ".$iloscArtykulow;  
        $statement = $connection->prepare( $sql );

        $statement->execute();
        $res = $statement->fetchAll();
        // var_dump($res);
        // exit();

        $artykuly = $this->arrayZDBIntoArtykuly( $res);
        return $artykuly;    
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

    /**
    *zamiana array pobranego z bazy danych na obiekty typu artykul
    *@param array zawierajacy tekst artykul pobrane z bazy danych
    *@return array zawierajacy obiekty classy Artykul
    */
    private function arrayZDBIntoArtykuly( $arrayArtykuly)
    {
        $artykuly = array();
        foreach ($arrayArtykuly as $key => $artykulArray) {
            $artykulArray['tresc'] = $artykulArray['artykul'];
            $artykul = new Artykul( $artykulArray );
            array_push( $artykuly,  $artykul );
        }

        return $artykuly;

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
        $artykulEntity->setIdHistori( $artykul->pobierzIDHistori() );
        return $artykulEntity;

    }


    /**
    *Funkcja tworzy nowy zapis w bazie histori modyfikacji artykulu
    *@param - obiekt typu artykul
    *@return int - id Histori
    */
    private function utworzNowaHistorie( $artykul )
    {
        $id = $this->zapiszHistorie( $artykul);
        return $id;
    }

    /**
    *Funkcja edytuje "ciag" zapisow w bazie histori modyfikacji artykulu - dodaje najnowsza modyfikacje
    *@param - obiekt typu artykul
    *@return int - id Histori
    */
    private function edytujHistoria($artykul, $idPoprzedniej = 0  )
    {
        $idPoprzedniej = $artykul->pobierzIDHistori();
        $id = $this->zapiszHistorie( $artykul, $idPoprzedniej);
        return $id;
    }

    /**
    *Funkcja zapisuje w bazie histori modyfikacje artykulu
    *@param - obiekt typu artykul, $idPoprzedniej - nr id histori do artykulu ktory zostal zmieniony
    *@return int - id Histori
    */
    private function zapiszHistorie( $artykul )
    {
       $historia = new HistoriaDB;

       //zapisz nazwe autora, musi byc zalogowany gdy tworzymy classe BazaArtykulow
       $autor = "anon";
       if (isset( $this->user) ) {
        $autor = $this->user;
       }
 

        $tekstArtykulu = $artykul->odczytajTresc();
        $idPoprzedniej = $artykul->pobierzIDHistori();


        if ($idPoprzedniej ===NULL or $idPoprzedniej == 0)
        {
            $idPoprzedniej = 0;
            $diff = StringDiff::compare( "", $tekstArtykulu  );
        }
        else 
        {
            $tytul = $artykul->odczytajTytul();
            $staryTekst = $this->odczytajArtykul($tytul)->odczytajTresc();
            $diff = StringDiff::compare( $staryTekst, $tekstArtykulu );

        }

        $statystyka = StringDiff::zwrocStatystyke( $diff );
        $krotkiDiff = StringDiff::skroconyDiff( $diff );

        //konieczna serializacja array aby zapisac w bazie danych 
        $serializeDiff =  base64_encode( serialize( $diff ) );        
        $serializeStat = base64_encode( serialize($statystyka ));
        $serializeKrotkiDiff = base64_encode( serialize( $krotkiDiff ));

        //utworz entiy historia - z entity HistoriaDB
        $historia->setAutor( $autor );
        $historia->setDiff( $serializeDiff );
        $historia->setIdPoprzedniej( $idPoprzedniej );
        $historia->setStatystyka( $serializeStat );
        $historia->setKrotkiDiff( $serializeKrotkiDiff );

        //zapisz do bazy danych
        $em = $this->doctrine->getManager();;
        $em->persist( $historia );
        $em->flush();       

        //pobierzID
        $id = $historia->getId();
        return $id;
    }

    /**
    *Funkcja zwraca historia artykulu o podanym tytule
    *@param array zawierajacy diff (umozliwia odtworzenie poprzedniej wersji), skrocony_diff (do wyswietlania), statystyke(ile zostalo dodanyc, odjetych)
    */
    public function odczytajHistorie($tytul)
    {
        if ( $this->czyIstniejeTytul( $tytul ))
        {
            $idHistori = $this->zwrocIdHistori( $tytul );
            $historia = $this->pobierzHistorie( $idHistori);
            return $historia;
        }
    }

    /**
    Funckcja zwraca historie artykulu i dostan jego idHistori
    @param - idHistori 
    $return zwraca array zawierajacy obiekt klasy Entity - HistoriaDB
    */
    public function pobierzHistorie($id)
    {
        $entityManager = $this->doctrine->getManager();
        $adres_bazy = $this->pobierzAdresBazyHistori();
        $dql = "SELECT HistoriaDB FROM ".$adres_bazy.' HistoriaDB WHERE HistoriaDB.id = :id';
        $query = $entityManager->createQuery($dql);
        $query->setParameter('id', $id);

        $res = $query->getResult();
        return $res;
       
    }

    /**
    *Zwraca stara wersje artykulu
    *@param - $tytul - tytul artykulu, $idStarego - nr id sterej histori 
    *@return - obiekt typu artykul gdzie tresc jest trescia starej wersji artykulu
    */
    public function pobierzStaryArtykul($tytul, $idStarejHistori, $maxIloscHistori = 50 )
    {
        //pobierz aktualna wersje artykulu
        $artykul = $this->odczytajArtykul($tytul);  
        $idHistori = $artykul->pobierzIDHistori();
        $tekstArtykulu = $artykul->odczytajTresc();
        // var_dump($tekstArtykulu);

        $i = $maxIloscHistori; //dla zabezpieczenia przed nieskonczona petla
        while($idHistori != $idStarejHistori and $idHistori != 0)
        {
            $historia = $this->pobierzHistorie($idHistori)[0] ;

            //dokonaj konwersji na stara wersje - stary tekst artykulu
            $diff =$historia->getArrayDiff();
            $tekstArtykulu =  StringDiff::zwrocStaryString($diff, $tekstArtykulu);

            //ustaw idHistori nastepnej wersji historii
            $idHistori = $historia->getIdPoprzedniej();

            $i-=1;
            if( $i<=0 ) {break;}
        }   

        $artArray = array("tytul" => $tytul, "tresc" => $tekstArtykulu);
        $artykul = $this->nowyArtykul( $artArray );  
        return $artykul;      
    }

    /**
    *Podaj tytul artykulu i dostan jego idHistori
    *@param - tytul artykuly
    *@return idHistori danego artykulu
    */
    private function zwrocIdHistori( $tytul )
    {
        $entityManager = $this->doctrine->getManager();
        $adres_bazy = $this->pobierzAdresBazyDanych();
        $dql = "SELECT ArtykulDB.idHistori FROM ".$adres_bazy.' ArtykulDB WHERE ArtykulDB.tytul = :tytul';
        $query = $entityManager->createQuery($dql);
        $query->setParameter('tytul', $tytul);

        $res = $query->getResult();
        return $res[0]['idHistori'];
    }

}
