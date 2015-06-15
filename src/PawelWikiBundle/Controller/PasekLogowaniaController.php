<?php 

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
* 
*/
class PasekLogowaniaController extends Controller
{
	public function pokazLogowanieAction()
	{
		$id =  $this->get('security.token_storage')->getToken()->getUser();

		$czy_zalogowany  = ($id !== "anon." ? true : false);

		if ( $czy_zalogowany === true )
		{
			$zwracany_tekst = "Witaj ".$id->getLogin();
		}
		else 
		{
			$zwracany_tekst = "Zaloguj sie";
		}



		$response = new Response();

		$response->setContent($zwracany_tekst);
		$response->setStatusCode(Response::HTTP_OK);
		$response->headers->set('Content-Type', 'text/html');

		// prints the HTTP headers followed by the content
		return $response;

		
	}
}