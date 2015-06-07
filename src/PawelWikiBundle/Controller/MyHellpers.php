<?php
namespace PawelWikiBundle\Controller;

class MyHellpers
{

	static public function zamienSpacjeNaPodkreslenia($string)
	{
		$string = trim($string); //pozbodz sie spacji z poczatki i konca
		return str_replace(" ", "_", $string); //zamiana spacji na podkreslenia
	}
}	