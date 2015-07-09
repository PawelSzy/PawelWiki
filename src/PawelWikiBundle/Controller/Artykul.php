<?php



namespace PawelWikiBundle\Controller;

use PawelWikiBundle\Controller\ArtykulInterface;
use PawelWikiBundle\Controller\getActualRepository;
use PawelWikiBundle\Controller\ZamienWikiCodeToHTML;

class Artykul implements ArtykulInterface
{

    private $id;
    private $tytul;
    private $tresc;
    private $dataZmiany;
    private $idHistori;
    private $repository;
    function __construct($artykulObject)
    {
        $this->id = isset(  $artykulObject["id"] )? $artykulObject["id"] : NULL;
        $this->tytul = $artykulObject["tytul"];
        $this->tresc = $artykulObject["tresc"];
        $this->dataZmiany= isset(  $artykulObject["dataZmiany"] )? $artykulObject["dataZmiany"] : NULL;
        $this->idHistori= isset(  $artykulObject["idHistori"] )? $artykulObject["idHistori"] : NULL;
    }


    public function zmienTytul($nowyTytul)
    {
        $this->tytul = $nowyTytul;
    }

    public function zmienTresc($nowaTresc)
    {
        $this->tresc = $nowaTresc;
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
        pass;
        //return $this->idHistori;
    }


    public function zmienIDHistori($idHistori)
    {
        $this->idHistori= $idHistori;
        return $this;   
    }

    public function pobierzIDHistori()
    {
        return $this->idHistori;
    }

    public function zapiszRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    private function getRouter()
    {
        if ( isset($this->router) )
        {
            return $this->router;
        }
        else {
            return NULL;
        }
    }

    /**
    *@param - router - obiekt pochodzacy z Symfony - sluzy do wyznaczania adresu
    *@return - funkcja zwraca zkonwertowany tekst odczytany z bazy danych (w kodzie WikiCode) na html
    */
    public function zwrocHTML( $router = NULL)
    {


        //w celu bezpieczenstwa tekst z bazy danych pozbadz sie html
        $escapedTresc = htmlentities( $this->odczytajTresc() );

        //konwersja i zwroc dane
        $htmlTresc = ZamienWikiCodeToHTML::konwersjaWikiCodeToHTML( $escapedTresc );
        
        //jesli nie zapisano
        //sprawdz czy istnieje router zapisany w obiekcie artykul
        if ( $router == NULL )
        {
            $router = $this->getRouter();
        }


        //zamien wszystkie linki_code na linki w HTML
        if( $router !== NULL)
        {
            $htmlTresc = $this->linkCodeToHTML( $htmlTresc, $router );
        }
        return $htmlTresc;
    }

    /**
    *Funkcja zwraca kawalek tekstu zawierajacy szukany tekst
    *@param szukanyTekst - string, route - obiekt pochodzacy z Symfony - sluzy do wyznaczania adresu
    *@param ilosc znakow - ile znakow przed i po szukanym tekscie ma pokazac
    *@return - string zawierajacy wyszukany wyraz oraz tekst z jego "okolic"
    */
    public function wyszukajSnippet($szukanyTekst = "", $iloscZnakow = 50, $router = NULL)
    {

        
        if ( $szukanyTekst == "" or $szukanyTekst ==NULL )
        {
            return $this->zwrocHTML( $router);
        }
        $tekstArtykulu = $this->zwrocHTML( $router);
        $snippet = $this->podzielString($tekstArtykulu, $szukanyTekst, $iloscZnakow);

        return $snippet;
    }

    /**
    * zamiana linkow zawartych w tresc( zapisanej w WikiCode) na linki w html
    *@param - string z linkami w WikiCode
    *@return - string z linkami w HTML
    */
    private function linkCodeToHTML( $htmlTresc, $router)
    {
        list($stringsToChange, $URL) =ZamienWikiCodeToHTML::pobierzGeneracjaUrl( $htmlTresc );
        $listaUrlDoStrony = array();
        foreach ( $URL as $key => $nazwaArtykulu ) {

            list( $nazwaArtykulu2, $nazwa_linku ) =  $this->podzielAdresnaAdresNazweLinki( $nazwaArtykulu );
            if ( $nazwaArtykulu2 !==FALSE ) {
                //url zostal zakodowany w postaci [[nazwaArtykulu, nazwaLinkuWyswietlanaNastronie]]
                $urlDoStrony = $router->generate("pawel_wiki_strona", array("tytul" => $nazwaArtykulu2), true);
                $urlDoStrony = '<a href="'.$urlDoStrony.'">'.$nazwa_linku."</a>";                   
            }
            else {
                //url zostal zakodowany [[nazwaArtykulu]] w wikicode
                $urlDoStrony = $router->generate("pawel_wiki_strona", array("tytul" => $nazwaArtykulu), true);
                $urlDoStrony = '<a href="'.$urlDoStrony.'">'.$nazwaArtykulu."</a>";                  
            }
            //dodaj url do listyUrl
            array_push($listaUrlDoStrony, $urlDoStrony);

        };
        $htmlTresc = str_replace($stringsToChange, $listaUrlDoStrony, $htmlTresc);  
        
        return $htmlTresc;      
    }

    private function podzielAdresnaAdresNazweLinki($url)
    {
        //@param - string zawierajacy pierwszy wyraz - nazwaArtykulu, drugi wyraz - nazwa linku wyswietlana w przegladarce
        //wyrazy rozdzielane sa spacja
        //@return - zwraca array zawierajacy podzial wyrazow gdy string zawiera dwa wyrazy, zwraca FALSE gdy jest tylko jeden wyraz

        //pozbadz sie spacji z poczatki i konca
        $url = trim($url);
        //sprawdz czy url zawiera spacje
        $gdzieSpacja = strpos($url, " ");
        //jesli zawiera spacje podziel artykul na dwie czesc
        //pierwsza to url
        //druga to nazwa linku
        if ($gdzieSpacja !== FALSE) {
            $new_url = substr($url, 0, $gdzieSpacja);
            $nazwa_linku = substr($url, $gdzieSpacja+1);
            return array($new_url, $nazwa_linku);
        }
        else {
            return array(FALSE,FALSE);
        }

    }


    /**
    *function that returns part of string before and after specified sub-string
    */
    private function podzielString($str, $query, $numOfWordToAdd) 
    {
        list($before, $after) = explode($query, $str);

        $before = rtrim($before);
        $after  = ltrim($after);

        $beforeArray = array_reverse(explode(" ", $before));
        $afterArray  = explode(" ", $after);

        $countBeforeArray = count($beforeArray);
        $countAfterArray  = count($afterArray);

        $beforeString = "";
        if($countBeforeArray < $numOfWordToAdd) {
            $beforeString = implode(' ', $beforeArray);
        }
        else {
            for($i = 0; $i < $numOfWordToAdd; $i++) {
                $beforeString = $beforeArray[$i] . ' ' . $beforeString; 
            }
        }

        $afterString = "";
        if($countAfterArray < $numOfWordToAdd) {
            $afterString = implode(' ', $afterArray);
        }
        else {
            for($i = 0; $i < $numOfWordToAdd; $i++) {
                $afterString = $afterString . $afterArray[$i] . ' '; 
            }
        }

        $string = $beforeString . $query . ' ' . $afterString;

        return $string;

    }
}
