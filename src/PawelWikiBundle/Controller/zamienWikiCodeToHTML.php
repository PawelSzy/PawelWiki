<?php

class zamienWikiCodeToHTML
{
	private static $RULES = array(
		"/=====([^=]*)=====/" => '<h5>\1</h5>' ,
		"/====([^=]*)====/" => '<h4>\1</h4>',
		"/===([^=]*)===/" => '<h3>\1</h3>' ,
		"/==([^=]*)==/" => '<h2>\1</h2>',
		"/''''([^\']*)''''/" => '<i><b>\1</b></i>',
		"/'''([^\']*)'''/" => '<b>\1</b>',
		"/''([^\']*)''/" => '<i>\1</i>',		
		'/(https?):\/\/(([A-Za-z0-9_-]+)\.([A-Za-z0-9_-]+((\/|\.)[A-Za-z0-9_-]+)*))/' => '<url="\1://\2">\2</url>',
		"/\[\[([^\[\]]*)\|([^\[\]]*)\]\]/" => '<url="$router->generate(\'pawel_wiki_artykul\', array(\'tytul\' => \'\1\'))\'">\2</url>',
		"/\[\[([^\[\]]*)\]\]/" => '$router->generate("pawel_wiki_artykul", array("tytul" => "\1"))',
		"/\[\[([^\[\]]*)#([^\[\]]*)\]\]/" => '$router->generate("pawel_wiki_artykul", array("tytul" => "\1#\2"))',
		"/((\*([A-Za-z0-9_-]+))+)+/" => '<li>\3</li>',
		//"/((<li>.*<\/li>)\s?(<li>.*<\/li>)+)/" => '<ul>\1</ul>',
		"/((#([A-Za-z0-9_-]+))+)+/" => '<li>\3</li>',
		"/((<li>.*<\/li>)\s?(<li>.*<\/li>)*)/" => '<ul>\1</ul>',		
		
		

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
"http://go_og-le.com.pl/test/test2   "."\n".
"http://google.com/test/test2/test3"."\n".
"[[husaria]]"."\n".
"[[husaria#bron]]"."\n".
"[[husaria|husariiiiii]]"."\n".
"*tesr"."\n"."*test2"."\n".
"#tesr3"."\n"."#test4"."\n".
"tessssssssssssssssss"."\n".
"*tes5r"."\n"."*test6"."\n"
;
echo zamienWikiCodeToHTML::konwersjaWikiCodeToHTML( $string );
echo "\n";