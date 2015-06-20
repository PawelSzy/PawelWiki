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

$string2 = "*
1
2
new
4
*
*
new
5
new
6
";
/** 
Classa zajmuje sie roznica pomiedzy strigami 
*/
class StringDiff 
{

  // const UNMODIFIED = 0;
  // const DELETED    = 1;
  // const INSERTED   = 2;



	// static function pokazRoznice( $string1, $string2 )
	// {

	// 	$allDiff  = Diff::compare($string1, $string2 );
	// 	//echo Diff::toString( $allDiff );

	// 	$diff = array();
	// 	$lenDif = count($allDiff);
	// 	for ($i=0; $i < $lenDif; $i++) { 
	// 		if ($allDiff[$i][1] !=SELF::UNMODIFIED)
	// 		{
	// 			$diff[(string)$i] = $allDiff[$i]; 
	// 		}
	// 	}
	// 	//var_dump($diff);
	// 	$stringDiff =  Diff::toString( $diff );
	// 	return array($diff, $stringDiff);
	// }

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
			if ($daneLinii[1] ==Diff::DELETED)
			{
				//fnkcja odwrotna do tworzenia
				//dodaj nowa linie do array
				$arrString = SELF::dodajLinie( $arrString, $r, $daneLinii[0] );
				$r +=1;
			}
			//usun linie
			elseif ($daneLinii[1] ==DIff::INSERTED)
			{
				//fnkcja odwrotna do tworzenia
				//usun nowa linie do array
				$arrString = SELF::usunLinie( $arrString, $r );
 			
			}
			else 
			{
				$r +=1;
			}		
			echo "i: ".$i."\n";
			echo "r: ".$r."\n";	
			echo "**************: \n";			
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
}


$diff = Diff::compare($string1, $string2 );

echo "\n-------------- \n";
var_dump($diff);


echo "\n-------------- \n";
// echo $stringDiff;



echo Diff::toString($diff);

$oldString =  StringDiff::zwrocStaryString($diff, $string2) ;
echo $oldString;
echo $string1;


//testowanie klasy
$ar1 = explode("\n", $string1);
$ar2 = explode("\n", $oldString);

echo "Czy udalo sie wrocic do starego tekstu ".assert( strcmp( $oldString, $string1 ) );  


//// Uzyj explode aby rozebrac na stringi po linie z podzialem \n 

