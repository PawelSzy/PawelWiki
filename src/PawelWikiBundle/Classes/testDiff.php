<?php

include 'classDiff.php';

//echo "test";

$string1 = "
1
2
3
4
5
";

$string2 = "
1
new
new
3
4
";

class StringDiff 
{
  const UNMODIFIED = 0;
  const DELETED    = 1;
  const INSERTED   = 2;



	static function pokazRoznice( $string1, $string2 )
	{

		$allDiff  = Diff::compare($string1, $string2 );
		//echo Diff::toString( $allDiff );

		$diff = array();
		$lenDif = count($allDiff);
		for ($i=0; $i < $lenDif; $i++) { 
			if ($allDiff[$i][1] !=SELF::UNMODIFIED)
			{
				$diff[(string)$i] = $allDiff[$i]; 
			}
		}
		//var_dump($diff);
		$stringDiff =  Diff::toString( $diff );
		return array($diff, $stringDiff);
	}

	static function zwrocStarySring($diff, $newString) 
	{
		$arrString = explode("\n", $newString);
		echo "*******************************\n";
		//var_dump($arrString);
		//$lenDif = count($diff);
		//krsort($diff); //sortuj od najwiekszego key do najmiejszego
		foreach ($diff as $nrLinii => $daneLinii)
		{ 
			//dodaj stara linie
			if ($daneLinii[1] ==SELF::DELETED)
			{
				//fnkcja odwrotna do tworzenia
				//dodaj nowa linie do array
				$arrString = SELF::dodajLinie( $arrString, $nrLinii, $daneLinii[0] );
			}
			//usun linie
			if ($daneLinii[1] ==SELF::INSERTED)
			{
				//fnkcja odwrotna do tworzenia
				//usun nowa linie do array
				$arrString = SELF::usunLinie( $arrString, $nrLinii );
			}			
		}	
		//var_dump($arrString);
		echo "\n*******************************\n";
		return implode("\n", $arrString);
	}	

	static function dodajLinie( $array, $nrLinii, $nowaLinia )
	{
		array_splice( $array, $nrLinii, 0, $nowaLinia );
		return $array;
	}	
	static function usunLinie( $array, $nrLinii)
	{
		echo "nrLinii ".$nrLinii."\n";
		var_dump($array);
		unset($array[$nrLinii]);
		echo "unset\n";
		echo "nrLinii ".$nrLinii."\n";
		var_dump($array);
		$array = array_values($array);
		echo "array Val\n";
		var_dump($array);
		return $array;
	}		
}

list($diff, $stringDiff) = StringDiff::pokazRoznice( $string1, $string2 );


//var_dump($diff);
//echo $stringDiff;

echo StringDiff::zwrocStarySring($diff, $string2) ;


//array_splice($arr_alphabet, 2, 0, 'c');
//unset($array[2]);
// $array = array_values($array);


// }

//$oldString = zwrocStarySring($diff, $newString);
// echo "Czy udalo sie wrocic do starego tekstu ".(assert($string2 === $string2));  


//// Uzyj explode aby rozebrac na stringi po linie z podzialem \n 

