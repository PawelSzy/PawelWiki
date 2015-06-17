<?php 

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
* 
*/
class PasekLogowaniaController extends Controller
{
	public function czyZalogowanyAction()
	{
		$id =  $this->get('security.token_storage')->getToken()->getUser();

		$czy_zalogowany  = ($id !== "anon." ? true : false);

		if ( $czy_zalogowany === true )
		{
			$zwracany_tekst = "true"; //"Witaj ".$id->getLogin();
		}
		else 
		{
			$zwracany_tekst = "false" ;//"Zaloguj sie "."{{ path('login') }}";
		}

		$response = new Response();

		$response->setContent($zwracany_tekst);
		$response->setStatusCode(Response::HTTP_OK);
		$response->headers->set('Content-Type', 'text/html');

		// prints the HTTP headers followed by the content
		return $response;		
	}

	public function pobierzLoginAction()
	{
		$id =  $this->get('security.token_storage')->getToken()->getUser();

		$czy_zalogowany  = ($id !== "anon." ? true : false);

		if ( $czy_zalogowany === true )
		{
			$zwracany_tekst = $id->getLogin();
		}
		else 
		{
			$zwracany_tekst = "false" ;
		}

		$response = new Response();

		$response->setContent($zwracany_tekst);
		$response->setStatusCode(Response::HTTP_OK);
		$response->headers->set('Content-Type', 'text/html');

		// prints the HTTP headers followed by the content
		return $response;		
	}

}