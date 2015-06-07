<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\ZamienWikiCodeToHTML;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

	

class testStronaWikiCodeToHTML extends WebTestCase
{
	public function testStronaWikiCodeToHTML()
	{
		////////////////////////////////////////////////////////////////////////////
		// Utwórz nowa strone i sprawdz czy program wyswietla odpowiednie znaki HTML
		//funkcja sprawdza zamiane kodowania WikiCode na HTML
		////////////////////////////////////////////////////////////////////////////

		$client = static::createClient();
		$clawler = $client->request('GET', '/nowy_artykul');

		//zapisz nowy form
		$form = $clawler->selectButton('Zapisz')->form();
		
		$URL1 = " [[Artykul_test]] ";
		$URL2 = " [[Artykul_test Test_ART]] ";

		$tytul_testowanie = "htmlDoTestowania"; 
		$tresc_testowanie = '<h2>To nie powinno sie zmieniac w HTML</h2> '.$URL1.$URL2 ;
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
		$this->assertRegExp('/^[<h2>To nie powinno sie zmieniac w HTML<\/h2> )]/', $content);	

		//sprawdz czy udaje sie zmienic URL z WikiCode na format HTML wyswietlany na stronie
 		$generatedURL = $client->getContainer()->get('router')->generate("pawel_wiki_strona", array("tytul" => 'Artykul_test'), false);	
 		//czy zmienie URL w postaci [[Artykul_test]]?
 		$this->assertRegExp('#'.$generatedURL.'#', $content);
 		//czy zmienie URL w postaci [[Artykul_test Test_ART]]?
 		$this->assertRegExp('#'.$generatedURL.'">Test_ART</a>'.'#', $content);

		//skasuj strone
		$clawler = $client->request('GET', '/skasuj/'.$tytul_testowanie);
		//sprawdz czy nie wyswietla artykulu
		$clawler = $client->request('GET', '/strona/'.$tytul_testowanie);
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/Nie znaleziono tytulu/', $content);
		
	}
}