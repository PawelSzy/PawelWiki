<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\Artykul;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class testWyswietlStrone extends WebTestCase
{
	public function testWyswietlStrone()
	{
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
	}
}