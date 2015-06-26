<?php


namespace PawelWikiBundle\Classes;

include 'classDiff.php';

//echo "test";


/** 
Classa zajmuje sie roznica pomiedzy strigami 
*/
class StringDiff extends Diff
{

  // const UNMODIFIED = 0;
  // const DELETED    = 1;
  // const INSERTED   = 2;

	/**
  	---- Funkcja zwraca skrocony diif - tylko dodane i skasowane linie
	// @param diff - array zawierajacy roznice pomiedzy dwoma stringami - podzoci z classDiff
	@return array skrocony diif - tylko dodane i skasowane linie
	*/
	public static function skroconyDiff( $oldDiff )
	{
		$diff = array();
		$lenDif = count($oldDiff);
		for ($i=0; $i < $lenDif; $i++) { 
			if ($oldDiff[$i][1] !=SELF::UNMODIFIED)
			{
				$diff[(string)$i] = $oldDiff[$i]; 
			}
		}

		return array($diff);
	}

  	/**
  	---- Funkcja zwraca stara wersje tekstu na podstawie nowego i roznicy pomiedzy nimi
	// @param diff - array zawierajacy roznice pomiedzy dwoma stringami - podzoci z classDiff
	// @param #newString - nowy string - zostanie skonwertoany do starszej wersji
	// @param $nowaLinia - znak rozdziajacy odzielne linie stringa
	// @return - string bedacy starsza wersja
  	*/
	public static function zwrocStaryString($diff, $newString, $znakNowalinia = "\n") 
	{ 

		$arrString = explode("\n", $newString);
		$r = 0;
		foreach ($diff as $i => $daneLinii)
		{ 
			//dodaj stara linie
			if ($daneLinii[1] ==SELF::DELETED)
			{
				//fnkcja odwrotna do tworzenia
				//dodaj nowa linie w array
				$arrString = SELF::dodajLinie( $arrString, $r, $daneLinii[0] );
				$r +=1;
			}
			//usun linie
			elseif ($daneLinii[1] ==SELF::INSERTED)
			{
				//fnkcja odwrotna do tworzenia
				//usun nowa linie w array
				$arrString = SELF::usunLinie( $arrString, $r );
 			
			}
			else 
			{
				$r +=1;
			}		
			// echo "i: ".$i."\n";
			// echo "r: ".$r."\n";	
			// echo "**************: \n";			
		}	
		return implode("\n", $arrString);
	}	

	private static function dodajLinie( $array, $nrLinii, $nowaLinia )
	{
		array_splice( $array, $nrLinii, 0, $nowaLinia );
		return $array;
	}	
	private static function usunLinie( $array, $nrLinii)
	{
		unset($array[$nrLinii]);
		$array = array_values($array);
		return $array;
	}		

	/**
	Funkcja zwraca ilosc dodanych i usunietych linii 
	@param diif - array zawierajacy roznice pomiedzy dwoma stringami
	@return array("+" => ilosc dodanych, "-" => ilosc usunietych)
	*/
	public static function zwrocStatystyke($diff)
	{
		$array = array("+" => 0, "-" =>0);

		foreach ($diff as $key => $value) {
			if( $value[1] ==SELF::INSERTED)
			{
				$array["+"] +=1;
			}
			elseif ( $value[1] ==SELF::DELETED )
			{
				$array["-"] +=1;
			}
		}
		return $array;
	} 
}


