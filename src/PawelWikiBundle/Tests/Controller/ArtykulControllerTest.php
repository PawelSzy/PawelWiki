<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\Artykul;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class testArtykul extends \PHPUnit_Framework_TestCase
{
	public function testZbudujArtykul()
	{
		//const artykulRepositoryTest = 'PawelWikiBundle:ArtykulDB:ArtykulDB';

		$daneArtykulu = array(
	    	"id" => 555,
	    	"tytul" => "Przykladowy_tytul",
	    	"tresc" => "Przykladowa_tresc",
	    	"dataZmiany" => "24.05.2015",
	    	"idHistori" => 777
		);
		$artykul = new Artykul( $daneArtykulu );

		$this->assertEquals( $daneArtykulu["id"], $artykul->odczytajId() );
		$this->assertEquals( $daneArtykulu["tytul"], $artykul->odczytajTytul() );
		$this->assertEquals( $daneArtykulu["tresc"], $artykul->odczytajTresc() );
		$this->assertEquals( $daneArtykulu["dataZmiany"], $artykul->odczytajDateUtworzenia() );
		$this->assertEquals( $daneArtykulu["idHistori"], $artykul->pobierzIDHistori() );
	}
}

class testStronaZArtykulem extends WebTestCase
{
	public function testStronaZArtykulem()
	{
		$client = static::createClient();
		$clawler = $client->request('GET', '/artykul/Artykul_test');
		
		/////////////////////////////////////////////////////////////////////
		$results = $clawler->filter('html:contains("Artykul test")')->count();
		$this->assertGreaterThan(0, $results);

		/////////////////////////////////////////////////////////////////////
		$results = $clawler->filter('html:contains("Husaria")')->count();
		$this->assertGreaterThan(0, $results);

		/////////////////////////////////////////////////////////////////////
		$content = $client->getResponse()->getContent();
		$tekstDoTestowanie = htmlentities("Husaria – polska jazda należąca do autoramentu narodowego, znana z wielu zwycięstw formacja kawaleryjska Rzeczypospolitej, obecna na polach bitew od początku XVI");
		$this->assertRegExp('/'.$tekstDoTestowanie.'/', $content);			
	}
}