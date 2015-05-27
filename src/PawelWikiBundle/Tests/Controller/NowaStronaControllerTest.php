<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\Artykul;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class testNowaStrone extends WebTestCase
{
	public function testNowaStrone()
	{
		//////////////////////
		// Utwórz nowa strone
		/////////////////////

		$client = static::createClient();
		$clawler = $client->request('GET', '/nowy_artykul');

		//zapisz nowy form
		$form = $clawler->selectButton('Zapisz')->form();
		
		$tytul_testowanie = 'Tytul_Do_testowania' ; 
		$tresc_testowanie = "Tresc form do testowania";
		$form['form[tytul]'] = $tytul_testowanie;
		$form['form[tresc]'] = $tresc_testowanie;

		$crawler2 = $client->submit($form);
	
		//sprawdz czy form popralo odpowiednie wartosc
		$data = $form->getPhpValues();
		$this->assertEquals($tytul_testowanie, $data['form']['tytul']);
		$this->assertEquals($tresc_testowanie, $data['form']['tresc']);

		
		
		// /////////////////////////////////////////////////////////////////////
		// $results = $clawler->filter('html:contains("Artykul_test")')->count();
		// $this->assertGreaterThan(0, $results);


		// /////////////////////////////////////////////////////////////////////
		// $results = $clawler->filter('html:contains("Husaria")')->count();
		// $this->assertGreaterThan(0, $results);

		// /////////////////////////////////////////////////////////////////////
		// $content = $client->getResponse()->getContent();
		// $this->assertRegExp('/Husaria – polska jazda należąca do autoramentu narodowego, znana z wielu zwycięstw formacja kawaleryjska Rzeczypospolitej, obecna na polach bitew od początku XVI/', $content);		
	
		// //sprawdz czy istnieje stopka  /////////////////////////////////////////////////////////
		// $this->assertRegExp('/Testowa wersja Wiki stworzona przez Pawla Szymańskiego/', $content);
		// //sprawdzy czy istnieje classa stopka
		// $this->assertRegExp('/class="stopka"/', $content);

	}
}