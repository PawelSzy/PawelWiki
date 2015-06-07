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
	    	//"[https://google.pl google]" => '<a href="https://google.pl">google</a>'
		);


		foreach ($wikiCodeArray as $wikiCode => $htmlTest) {
			$skonwertowanyHTML = ZamienWikiCodeToHTML::konwersjaWikiCodeToHTML( $wikiCode );
			$this->assertEquals( $skonwertowanyHTML, $htmlTest );
		};
	}
}		
		

// 		$this->assertEquals( $daneArtykulu["id"], $artykul->odczytajId() );
// 		$this->assertEquals( $daneArtykulu["tytul"], $artykul->odczytajTytul() );
// 		$this->assertEquals( $daneArtykulu["tresc"], $artykul->odczytajTresc() );
// 		$this->assertEquals( $daneArtykulu["dataZmiany"], $artykul->odczytajDateUtworzenia() );
// 		$this->assertEquals( $daneArtykulu["idHistori"], $artykul->pobierzIDHistori() );
// 	}
// }

// class testStronaZArtykulem extends WebTestCase
// {
// 	public function testStronaZArtykulem()
// 	{
// 		// $client = static::createClient();
// 		// $clawler = $client->request('GET', '/artykul/Artykul_test');
		
// 		// /////////////////////////////////////////////////////////////////////
// 		// $results = $clawler->filter('html:contains("Artykul_test")')->count();
// 		// $this->assertGreaterThan(0, $results);


// 		// /////////////////////////////////////////////////////////////////////
// 		// $results = $clawler->filter('html:contains("Husaria")')->count();
// 		// $this->assertGreaterThan(0, $results);

// 		// /////////////////////////////////////////////////////////////////////
// 		// $content = $client->getResponse()->getContent();
// 		// $tekstDoTestowanie = htmlentities("Husaria – polska jazda należąca do autoramentu narodowego, znana z wielu zwycięstw formacja kawaleryjska Rzeczypospolitej, obecna na polach bitew od początku XVI");
// 		// $this->assertRegExp('/'.$tekstDoTestowanie.'/', $content);			
// 	}
// }