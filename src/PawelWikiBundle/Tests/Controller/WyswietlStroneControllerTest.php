<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\Artykul;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class testWyswietlStrone extends WebTestCase
{
	public function testWyswietlStrone()
	{
		//////////////////////
		// Test dla przykladowej strony Artykul_test
		/////////////////////
		$client = static::createClient();
		$clawler = $client->request('GET', '/strona/Artykul_test');
		
		/////////////////////////////////////////////////////////////////////
		$results = $clawler->filter('html:contains("Artykul_test")')->count();
		$this->assertGreaterThan(0, $results);


		/////////////////////////////////////////////////////////////////////
		$results = $clawler->filter('html:contains("Husaria")')->count();
		$this->assertGreaterThan(0, $results);

		/////////////////////////////////////////////////////////////////////
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/Husaria – polska jazda należąca do autoramentu narodowego, znana z wielu zwycięstw formacja kawaleryjska Rzeczypospolitej, obecna na polach bitew od początku XVI/', $content);		
	
		//sprawdz czy istnieje stopka  /////////////////////////////////////////////////////////
		$this->assertRegExp('/Testowa wersja Wiki stworzona przez Pawla Szymańskiego/', $content);
		//sprawdzy czy istnieje classa stopka
		$this->assertRegExp('/class="stopka"/', $content);

	}
}