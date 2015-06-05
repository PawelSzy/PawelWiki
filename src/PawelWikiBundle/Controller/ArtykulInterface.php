<?php


namespace PawelWikiBundle\Controller;


interface ArtykulInterface 
{
    public function odczytajID();
    public function odczytajTytul();
    public function odczytajTresc();
    public function odczytajDateUtworzenia();
    public function pobierzLinkDoHistori();
    public function pobierzIDHistori();
}