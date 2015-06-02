<?php

class zamienWikiCodeToHTML
{
	private static $RULES = array(
		"/==([^=]*)==/" => '<h2>\1<h2>' 
	);


	public static function konwersjaWikiCodeToHTML( $string)
	{
		foreach (SELF::$RULES as $pattern => $replacement) {
			echo preg_replace($pattern, $replacement, $string);		
		};

	}
}
echo "test";
$string = "==tekst==   ==tekst2==CCC";
echo zamienWikiCodeToHTML::konwersjaWikiCodeToHTML( $string );