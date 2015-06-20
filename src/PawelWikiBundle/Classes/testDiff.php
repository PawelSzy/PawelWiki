<?php

include 'classDiff.php';

//echo "test";

$string1 = "
1
2
3
4
5
6
7
";

$string2 = "
1
2
new
4
new
5
new
6
";
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
	static function skroconyDiff( $oldDiff )
	{
		$diff = array();
		$lenDif = count($oldDiff);
		print_r($oldDiff);
		for ($i=0; $i < $lenDif; $i++) { 
			if ($oldDiff[$i][1] !=SELF::UNMODIFIED)
			{
				$diff[(string)$i] = $oldDiff[$i]; 
			}
		}
		//var_dump($diff);

		return array($diff);
	}

  	/**
  	---- Funkcja zwraca stara wersje tekstu na podstawie nowego i roznicy pomiedzy nimi
	// @param diff - array zawierajacy roznice pomiedzy dwoma stringami - podzoci z classDiff
	// @param #newString - nowy string - zostanie skonwertoany do starszej wersji
	// @param $nowaLinia - znak rozdziajacy odzielne linie stringa
	// @return - string bedacy starsza wersja
  	*/
	static function zwrocStaryString($diff, $newString, $znakNowalinia = "\n") 
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

	static function dodajLinie( $array, $nrLinii, $nowaLinia )
	{
		array_splice( $array, $nrLinii, 0, $nowaLinia );
		return $array;
	}	
	static function usunLinie( $array, $nrLinii)
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
	static function zwrocStatystyke($diff)
	{
		$array = array("+" => 0, "-" =>0);
		return $array;
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
	} 
}


$diff = StringDiff::compare($string1, $string2 );

echo "\n-------------- \n";
var_dump($diff);


echo "\n-------------- \n";
// echo $stringDiff;



echo StringDiff::toString($diff);

$oldString =  StringDiff::zwrocStaryString($diff, $string2) ;
// echo $oldString;
// echo $string1;

// echo "podaj statystyke: ";
// print_r(StringDiff::zwrocStatystyke($diff) );

echo "\nskroconyDiff\n";
print_r( StringDiff::skroconyDiff($diff) );
//testowanie klasy


echo "Czy udalo sie wrocic do starego tekstu ".assert( strcmp( $oldString, $string1 ) );  


//// Uzyj explode aby rozebrac na stringi po linie z podzialem \n 

