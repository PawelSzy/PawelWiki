<?php
namespace PawelWikiBundle\Controller;

class ZamienWikiCodeToHTML
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
		'/\[<url=([^>]*)>([^<]*)<\/url> ([^\]]*)\]/' => '<url =\1>\3</url>',
		//'/\[(https?):\/\/(([A-Za-z0-9_-]+)\.([A-Za-z0-9_-]+((\/|\.)[A-Za-z0-9_-]+)*)) ([^\]]+)\]/' => '<url="\1://\2">\2</url>',
		"/\[\[([^\[\]]*)\|([^\[\]]*)\]\]/" => '<url="$router->generate(\'pawel_wiki_artykul\', array(\'tytul\' => \'\1\'))\'">\2</url>',
		"/\[\[([^\[\]]*)\]\]/" =>  '{{ $router->generate("pawel_wiki_artykul", array("tytul" => "\1"),true) }} ',
		"/\[\[([^\[\]]*)#([^\[\]]*)\]\]/" => '$router->generate("pawel_wiki_artykul", array("tytul" => "\1#\2"))',
		//unordered list
		"/[\n\r]?\*.+([\n|\r]\*.+)+/" =>'<ul>$0</ul>', 
		"/\* (.+)/"=> '<li>\1</li>',
		"/<\/ul><\/li>/" => '</li></ul>',
		//ordered
		"/[\n\r]?#.+([\n|\r]#.+)+/" => '<ol>$0</ol>', 
		"/# (.+)/"=> '<li>\1</li>',
		"/<\/ol><\/li>/" => '</li></ol>',
		//"/\\n/" => '<br>',
	);


	public static function konwersjaWikiCodeToHTML( $string)
	{
		foreach (SELF::$RULES as $pattern => $replacement) {
			$string = preg_replace($pattern, $replacement, $string);		
		};

		return $string;
	}
}
// echo "test";
// $string = "==tekst==   ==tekst2==CCC  ===H3=== ''italic''  '''bold'''  ''''ib'''' "."\n".
// " https://google.com/"."\n".
// "  https://google.com "."\n".
// "http://go_og_le.com/test"."\n".
// "http://go_og-le.com.pl/test/test2   "."\n".
//  "http://google.com/test/test2/test3"."\n".
// "[https://google.com.pl/test1/test2 google]"."\n".
// "[[husaria]]"."\n".
// "[[husaria#bron]]"."\n".
// "[[husaria|husariiiiii]]"."\n".
// "* tesr"."\n"."* test2"."\n".
// "* tes2.5"."\n"."* 2.75test2"."\n".
// "_______________________"."\n".
// "#tesr3"."\n"."#test4"."\n".
// "tessssssssssssssssss"."\n".
// "* tes5r"."\n"."* Test6"."\n"
// ;
// echo zamienWikiCodeToHTML::konwersjaWikiCodeToHTML( $string );
// echo "\n";