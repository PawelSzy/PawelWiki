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

    public function pobierzIDHistori()
    {
        return $this->idHistori;
    }

    public function zwrocHTML( $router = NULL)
    {
        //@param - router - obiekt pochodzacy z Symfony - sluzy do wyznaczania adresu
        //@return - funkcja zwraca zkonwertowany tekst odczytany z bazy danych (w kodzie WikiCode) na html

        //w celu bezpieczenstwa tekst z bazy danych pozbadz sie html
        $escapedTresc = htmlentities( $this->odczytajTresc() );
        //konwersja i zwroc dane
        $htmlTresc = ZamienWikiCodeToHTML::konwersjaWikiCodeToHTML( $escapedTresc );
        //zamien wszystkie linki_code na linki w HTML
        if( $router !== NULL)
        {
            list($stringsToChange, $URL) =ZamienWikiCodeToHTML::pobierzGeneracjaUrl($htmlTresc);
            $listaUrlDoStrony = array();
            foreach ( $URL as $key => $nazwaArtykulu ) {

                list( $nazwaArtykulu2, $nazwa_linku ) =  $this->podzielAdresLnaAdresNazweLinki( $nazwaArtykulu );
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
        }
        return $htmlTresc;
    }

    private function podzielAdresLnaAdresNazweLinki($url)
    {
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



}

