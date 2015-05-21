<?php



namespace PawelWikiBundle\Controller;

use PawelWikiBundle\Controller\ArtykulInterface;
use PawelWikiBundle\Controller\getActualRepository;

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
        $this->idHistori = $artykulObject["idHistori"];
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

