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

    public function zapiszArtykul()
    {
        if ( isset( $this->repository) )
        {

        }    
    }

}

