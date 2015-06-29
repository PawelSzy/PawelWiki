<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WyswietlZasadyController extends Controller
{
	public function wyswietlStroneZasadyAction()
	{
		$tytul = "wikiPawel zasady modyfikacji tekstu";
		return $this->render( 'PawelWikiBundle:Zasady:strona_zasady.html.twig', array( "tytul" => $tytul ));
	}

	public function wyswietlZasady()
	{
		return $this->render( 'PawelWikiBundle:Zasady:wiki_zasady.html.twig');
	}
}
