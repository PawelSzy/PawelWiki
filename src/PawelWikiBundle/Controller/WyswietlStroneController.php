<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\ArtykulFactory;

class WyswietlStroneController extends Controller
{
    public function WyswietlStroneAction($tytul)
    {
        
    return $this->render('PawelWikiBundle:Default:wiki_strona.html.twig', array('tytul' => $tytul));
    }
}
