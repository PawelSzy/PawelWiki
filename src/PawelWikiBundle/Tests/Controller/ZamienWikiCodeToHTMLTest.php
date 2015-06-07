<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\ZamienWikiCodeToHTML;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class testZamienWikiCodeToHTML extends \PHPUnit_Framework_TestCase
{
	public function testZamienWikiCodeToHTML()
	{
		//const artykulRepositoryTest = 'PawelWikiBundle:ArtykulDB:ArtykulDB';

		$wikiCodeArray = array(
			//testuj html tags
	    	"==Test356==" => "<h2>Test356</h2>",
	    	"===Test356===" => "<h3>Test356</h3>",
	    	"====Test356====" => "<h4>Test356</h4>",
	    	"=====Test356=====" => "<h5>Test356</h5>",
	    	//testuj URL
	    	"https://google.pl" => '<a href="https://google.pl">google.pl</a>',
	    	"[https://google.pl google]" => '<a href="https://google.pl">google</a>',
		);


		foreach ($wikiCodeArray as $wikiCode => $htmlTest) {
			$skonwertowanyHTML = ZamienWikiCodeToHTML::konwersjaWikiCodeToHTML( $wikiCode );
			$this->assertEquals( $skonwertowanyHTML, $htmlTest );
		};
	}
}		
	

class testStronaZzamienWikiCodeToHTML extends WebTestCase
{
	public function testStronaZamienWikiCodeToHTML()
	{
		////////////////////////////////////////////////////////////////////////////
		// Utwórz nowa strone i sprawdz czy program wyswietla odpowiednie znaki HTML
		////////////////////////////////////////////////////////////////////////////

		$client = static::createClient();
		$clawler = $client->request('GET', '/nowy_artykul');

		//zapisz nowy form
		$form = $clawler->selectButton('Zapisz')->form();
		
		$URL1 = " [[Artykul_test]] ";
		$URL2 = " [[Artykul_test Test_ART]] ";
		$tytul_testowanie = '<h2>To nie powinno sie zmieniac w HTML</h2>'.$URL1.$URL2 ; 
		$tresc_testowanie = "Tresc form do testowania";
		$tresc_testowanie_zmiany_tresci = "Tresc form do testowania zmiany tresc artykulu";
		$form['form[tytul]'] = $tytul_testowanie;
		$form['form[tresc]'] = $tresc_testowanie;

		$crawler2 = $client->submit($form);
	
		//sprawdz czy form popralo odpowiednie wartosc
		$data = $form->getPhpValues();
		$this->assertEquals($tytul_testowanie, $data['form']['tytul']);
		$this->assertEquals($tresc_testowanie, $data['form']['tresc']);	


		//sprawdz czy nie wystepuja tagi <h2> w tekscie - sprawdzenie bezpieczenstwa
		$clawler = $client->request('GET', '/strona/'.$tytul_testowanie);
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/'.$tresc_testowanie_zmiany_tresci.'/', $content);		

		//skasuj strone
		$clawler = $client->request('GET', '/skasuj/'.$tytul_testowanie);
		//sprawdz czy nie wyswietla artykulu
		$clawler = $client->request('GET', '/strona/'.$tytul_testowanie);
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/<h2>To nie powinno sie zmieniac w HTML</h2>/', $content);

		// $client = static::createClient();
		// $clawler = $client->request('GET', '/artykul/Artykul_test');
		
		// /////////////////////////////////////////////////////////////////////
		// $results = $clawler->filter('html:contains("Artykul_test")')->count();
		// $this->assertGreaterThan(0, $results);


		// /////////////////////////////////////////////////////////////////////
		// $results = $clawler->filter('html:contains("Husaria")')->count();
		// $this->assertGreaterThan(0, $results);

		// /////////////////////////////////////////////////////////////////////
		// $content = $client->getResponse()->getContent();
		// $tekstDoTestowanie = htmlentities("Husaria – polska jazda należąca do autoramentu narodowego, znana z wielu zwycięstw formacja kawaleryjska Rzeczypospolitej, obecna na polach bitew od początku XVI");
		// $this->assertRegExp('/'.$tekstDoTestowanie.'/', $content);			
	}
}