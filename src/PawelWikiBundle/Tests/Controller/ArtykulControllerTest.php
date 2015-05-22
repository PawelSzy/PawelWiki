<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\Artykul;




class testArtykul extends \PHPUnit_Framework_TestCase
{
	public function testZbudujArtykul()
	{
		//const artykulRepositoryTest = 'PawelWikiBundle:ArtykulDB:ArtykulDB';

		$daneArtykulu = array(
	    	"id" => 555,
	    	"tytul" => "Przykladowy tytul",
	    	"tresc" => "Przykladowa tresc",
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