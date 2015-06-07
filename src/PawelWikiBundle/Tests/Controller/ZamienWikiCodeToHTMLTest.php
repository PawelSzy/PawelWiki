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
	
