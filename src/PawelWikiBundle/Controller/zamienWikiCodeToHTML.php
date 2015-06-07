<?php
namespace PawelWikiBundle\Controller;

class ZamienWikiCodeToHTML
{
	private static $RULES = array(
		//Glowne tagi HTML
		"/=====([^=]*)=====/" => '<h5>\1</h5>' ,
		"/====([^=]*)====/" => '<h4>\1</h4>',
		"/===([^=]*)===/" => '<h3>\1</h3>' ,
		"/==([^=]*)==/" => '<h2>\1</h2>',
		"/''''([^\']*)''''/" => '<i><b>\1</b></i>',
		"/'''([^\']*)'''/" => '<b>\1</b>',
		"/''([^\']*)''/" => '<i>\1</i>',	
		
		//zamiana linkow
		//linki bezposrednie - zwykle do URL na zewnatrz
		'/(https?):\/\/(([A-Za-z0-9_-]+)\.([A-Za-z0-9_-]+((\/|\.)[A-Za-z0-9_-]+)*))/' => '<a href="\1://\2">\2</a>',
		'/\[<a href=([^>]*)>([^<]*)<\/a> ([^\]]*)\]/' => '<a href=\1>\3</a>',
		//'/\[(https?):\/\/(([A-Za-z0-9_-]+)\.([A-Za-z0-9_-]+((\/|\.)[A-Za-z0-9_-]+)*)) ([^\]]+)\]/' => '<a href="\1://\2">\2</a>',
		
		//linki posrednie zwykle do URL nalezacych do symfony
		"/\[\[([^\[\]]*)\|([^\[\]]*)\]\]/" => '<a href="URL_SYMFONY(\'\1\')END_URL">\2</a>',
		"/\[\[([^\[\]]*)\]\]/" =>  'URL_SYMFONY(\1)END_URL',
		"/\[\[([^\[\]]*)#([^\[\]]*)\]\]/" => 'URL_SYMFONY(\1#\2)END_URL',
		
		//unordered list
		"/[\n\r]?\*.+([\n|\r]\*.+)+/" =>'<ul>$0</ul>', 
		"/\* (.+)/"=> '<li>\1</li>',
		"/<\/ul><\/li>/" => '</li></ul>',
		
		//ordered list
		"/[\n\r]?#.+([\n|\r]#.+)+/" => '<ol>$0</ol>', 
		"/# (.+)/"=> '<li>\1</li>',
		"/<\/ol><\/li>/" => '</li></ol>',
		"/\\n\\n/" => '<br>',
	);
	private static $RULES_URL = '/URL_SYMFONY\(([^\)]+)\)END_URL/'; 


	public static function konwersjaWikiCodeToHTML( $string)
	{
		//p@aram string zawierajacy WikiCode
		//@return string zawierajacy HTML
		foreach (SELF::$RULES as $pattern => $replacement) {
			$string = preg_replace($pattern, $replacement, $string);		
		};

		return $string;
	}

	public static function pobierzGeneracjaUrl( $string )
	{
		//@Return zwraca array zawierajacy string z wszystkimi URL w WikiCode
		//pierwszy zwracany wyraz to caly kod w WikiCode
		//drugi to  URL pobranyz z kody
		preg_match_all(SELF::$RULES_URL, $string, $matches);
		return array($matches[0], $matches[1]);
	}
}
