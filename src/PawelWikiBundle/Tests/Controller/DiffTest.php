<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Classes\StringDiff;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class testDiff extends \PHPUnit_Framework_TestCase
{
	public function testDiff()
	{
		$strings = array("
		1
		2
		3
		4
		5
		6
		7
		",

		"
		1
		2
		new
		4
		new
		5
		new
		6
		",

		"",
		"a 
		b
		c
		d
		e
		f",
		"
		a
		b
		new new
		c
		d
		new
		new"
		);	

		foreach ($strings as $string1) {
			foreach ($strings as $string2) {

				$diff = StringDiff::compare($string1, $string2 );
				$oldString =  StringDiff::zwrocStaryString($diff, $string2) ;
				$this->assertTrue( (bool)strcmp( $oldString, $string1 ) or $oldString === $string1 );
			}
		}
 

	}

	public function testzwrocStatystyke()
	{
		$string1 = "
			1
			2
		";
		$string2 = "
			2
			3
		";

		$diff = StringDiff::compare($string1, $string2 );
		$statystyka = StringDiff::zwrocStatystyke($diff);
		$this->assertEquals($statystyka, array("+" => 1, "-" =>1) );
	}


}