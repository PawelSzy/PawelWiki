<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;

class StronaGlownaController extends Controller
{
	public function StronaGlownaAction( )
	{
		$tytul = "PawelWiki Strona GLowna";
    	return $this->render( 'PawelWikiBundle:Default:strona_glowna.html.twig', array('tytul' => $tytul )) ;        
	}
}