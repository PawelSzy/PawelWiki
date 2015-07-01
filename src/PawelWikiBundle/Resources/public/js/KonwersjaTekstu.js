(function () {

var tabelaZmian = {
		//zamiana nowych lini
		//"/\n\n/" : '<br>' ,

		//Glowne tagi HTML
		//****************************************************************************************************
		"=====([^=]*)=====" : '<h5>$1</h5>' ,
		"====([^=]*)====" : '<h4>$1</h4>',
		"===([^=]*)===" : '<h3>$1</h3>' ,
		"==([^=]*)==" : '<h2>$1</h2>',
		"''''([^\']*)''''" : '<i><b>$1</b></i>',
		"'''([^\']*)'''" : '<b>$1</b>',
		"''([^\']*)''" : '<i>$1</i>',	
		//****************************************************************************************************
		
		//zamiana linkow
		//****************************************************************************************************
		//linki bezposrednie - zwykle do URL na zewnatrz
		//***************************************************
		//zamiana http://google.pl
		'(https?):\\/\\/(([A-Za-z0-9_-]+)\\.([A-Za-z0-9_-]+((\\/|\\.)[A-Za-z0-9_-]+)*))' : '<a href="$1://$2">$2</a>', 
		//zamien [http://google.pl TytulStrony] do dzialani wymaga powyzszej linijki
		'\\[<a href=([^>]*)>([^<]*)<\\/a> ([^\\]]*)\\]' : '<a href=$1>$3</a>',											
		// //'/\[(https?):\/\/(([A-Za-z0-9_-]+)\.([A-Za-z0-9_-]+((\/|\.)[A-Za-z0-9_-]+)*)) ([^\]]+)\]/' : '<a href="$1://$2">$2</a>',
		// //***************************************************

		// //linki posrednie zwykle do URL nalezacych do symfony
		// //***************************************************
		"\\[\\[([^\\[\\]]*) ([^\\[\\]]*)\\]\\]" : '<a href="http://localhost/xampp/symfony/PawelWiki/web/app_dev.php/strona/$1">$2</a>',
		 "\\[\\[([^\\[\\]]*)\\]\\]" :  '<a href="http://localhost/xampp/symfony/PawelWiki/web/app_dev.php/strona/$1">$1</a>',
		 "\\[\\[([^\\[\\]]*)#([^\\[\\]]*)\\]\\]" : '<a href="http://localhost/xampp/symfony/PawelWiki/web/app_dev.php/strona/$1#$2">$2</a>',
		// //***************************************************
		// //****************************************************************************************************

		//unordered list
		//****************************************************************************************************
		"[\\n\\r]?\\*.+([\\n|\\r]\\*.+)+" :'<ul>$&</ul>', 
		"\\* (.+)": '<li>$1</li>',
		"<\\/ul><\\/li>" : '</li></ul>',
		//****************************************************************************************************
		
		//ordered list
		//****************************************************************************************************
		"[\\n\\r]?#.+([\\n|\\r]#.+)+" : '<ol>$&</ol>', 
		"# (.+)": '<li>$1</li>',
		"<\\/ol><\\/li>" : '</li></ol>',

		//"\\n\\n" : '<br>',
		//****************************************************************************************************
	}

console.log(tabelaZmian["/=====([^=]*)=====/" ]);
$("#form_tresc").keyup(function(){
	wpisanyText = $("#form_tresc").val();
	tekstKonwertowany =wpisanyText ;
	for (keyRegExp in tabelaZmian) {
		regExp = new RegExp(keyRegExp, 'g')
		console.log(keyRegExp);
		tekstKonwertowany = tekstKonwertowany.replace(regExp, tabelaZmian[keyRegExp]);
		console.log(tabelaZmian[keyRegExp]);
	};

	//var tekstKonwertowany = wpisanyText.replace(/=====([^=]*)=====/g, "<h5>$1</h5>");
	$("#skonwertowany_tekst").html(
		tekstKonwertowany

		) 
	});



} ());
