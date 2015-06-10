<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PawelWikiInfoController extends Controller
{
    public function PawelWikiInfoAction()
    {	
        $tytul = "Informacje o PawelWiki";
        return $this->render('PawelWikiBundle:Default:pawel_wiki_info.html.twig', array('tytul' => $tytul));
    }
}