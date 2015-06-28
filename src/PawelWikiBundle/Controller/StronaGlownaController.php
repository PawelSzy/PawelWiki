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

		$najnowszeArtykulu = $this->pobierzNajnowszeArtykulu();
		var_dump($najnowszeArtykulu);
    	return $this->render( 'PawelWikiBundle:Default:strona_glowna.html.twig', array('tytul' => $tytul )) ;        
	}

	private function pobierzNajnowszeArtykulu( $iloscNowychArtykulow = 5)
	{
        $BazaArtykulow = new BazaArtykulow( $this->pobierzRepository(), $this->pobierzDoctrine() );
        $najnowszeArtykulu = $BazaArtykulow->pobierzNajnowszeArtykulu( $iloscNowychArtykulow );		
		return $najnowszeArtykulu;
	}
}