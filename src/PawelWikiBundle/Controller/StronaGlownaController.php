<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;

class StronaGlownaController extends Controller
{
	use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected;}
	public function StronaGlownaAction( )
	{
		$tytul = "PawelWiki Strona GLowna";

		$najnowszeArtykuly = $this->pobierzNajnowszeArtykuly();
    	return $this->render( 'PawelWikiBundle:Default:strona_glowna.html.twig', array('tytul' => $tytul, 'najnowszeArtykuly' => $najnowszeArtykuly)) ;        
	}

	private function pobierzNajnowszeArtykuly( $iloscNowychArtykulow = 5)
	{
        $BazaArtykulow = new BazaArtykulow( $this->pobierzRepository(), $this->pobierzDoctrine() );
        $najnowszeArtykuly = $BazaArtykulow->pobierzSkrotyNowychArtykulow( $iloscNowychArtykulow );		
		return $najnowszeArtykuly;
	}
}