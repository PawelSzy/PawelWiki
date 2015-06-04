<?php

class zamienWikiCodeToHTML
{
	private static $RULES = array(
		"/=====([^=]*)=====/" => '<h5>\1</h5>' ,
		"/====([^=]*)====/" => '<h4>\1</h4>',
		"/===([^=]*)===/" => '<h3>\1</h3>' ,
		"/==([^=]*)==/" => '<h2>\1</h2>',
		"/''''([^']*)''''/" => '<i><b>\1</b></i>',
		"/'''([^']*)'''/" => '<b>\1</b>',
		"/''([^']*)''/" => '<i>\1</i>',		
		'/(https?):\/\/(([A-Za-z0-9_-]+)\.([A-Za-z0-9_-]+(\/[A-Za-z0-9_-]+)*))/' => '<url="\1://\2">\2</url>',
		'/^(https?:\/\/)?([\da-z\.-]+).([a-z\.]{2,6})([\/\w \.-]*)*\/?$/' => '<url="\1">\1</url>'

	);


	public static function konwersjaWikiCodeToHTML( $string)
	{
		foreach (SELF::$RULES as $pattern => $replacement) {
			$string = preg_replace($pattern, $replacement, $string);		
		};

		return $string;
	}
}
echo "test";
$string = "==tekst==   ==tekst2==CCC  ===H3=== ''italic''  '''bold'''  ''''ib'''' "."\n"
." https://google.com/"."\n".
"  https://google.com "."\n".
"http://go_og_le.com/test"."\n".
"http://go_og-le.com/test/test2   "."\n".
"http://google.com/test/test2/test3   ";
echo zamienWikiCodeToHTML::konwersjaWikiCodeToHTML( $string );
echo "\n";