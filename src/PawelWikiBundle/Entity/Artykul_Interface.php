<?php

namespace PawelWikiBundle\Entity;

use Symfony\PawelWiki\src\PawelWikiBundle\Entity\Part_Interface.php;

//use Doctrine\ORM\Mapping as ORM;
/**
*
*/
interface  Artykul_Interface extends Part_Interface
{


	//////////////////////////
	//******** Funckcja zwraca DIV przygotowany do wyswietlenia na stronie
	//////////////////////
	public function zwrocDIV();
	public function edytujArtykul();
	public function historiaArtykulu();
	 
	 

}

