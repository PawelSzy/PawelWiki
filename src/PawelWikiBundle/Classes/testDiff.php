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

class StringDiff 
{
  const UNMODIFIED = 0;
  const DELETED    = 1;
  const INSERTED   = 2;



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

	static function zwrocStarySring($diff, $newString, $znakNowalinia = "\n") 
	{
		$i = count($diff);
		$r = count($newString); 

		$arrString = explode("\n", $newString);
		$r = 0;
		foreach ($diff as $i => $daneLinii)
		{ 
			//dodaj stara linie
			if ($daneLinii[1] ==SELF::DELETED)
			{
				//fnkcja odwrotna do tworzenia
				//dodaj nowa linie do array
				$arrString = SELF::dodajLinie( $arrString, $r, $daneLinii[0] );
				$r +=1;
			}
			//usun linie
			elseif ($daneLinii[1] ==SELF::INSERTED)
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
			echo "**************: "."\n";			
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

// list($diff, $stringDiff) = StringDiff::pokazRoznice( $string1, $string2 );

// echo "diff: \n";
// var_dump($diff);

$diff = Diff::compare($string1, $string2 );

echo "\n-------------- \n";
var_dump($diff);


echo "\n-------------- \n";
// echo $stringDiff;



echo Diff::toString($diff);

echo StringDiff::zwrocStarySring($diff, $string2) ;
//array_splice($arr_alphabet, 2, 0, 'c');
//unset($array[2]);
// $array = array_values($array);


// }

//$oldString = zwrocStarySring($diff, $newString);
// echo "Czy udalo sie wrocic do starego tekstu ".(assert($string2 === $string2));  


//// Uzyj explode aby rozebrac na stringi po linie z podzialem \n 

