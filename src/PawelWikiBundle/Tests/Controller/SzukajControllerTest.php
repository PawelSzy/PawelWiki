<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\Artykul;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;



class testSzukaj extends WebTestCase
{
	/**
	*Test szukania tekstu w bazie danych
	*/
	public function testSzukaj()
	{

		$client = static::createClient();
		$clawler = $client->request('GET', '/szukaj');

		//zapisz nowy form
		$form = $clawler->selectButton('Szukaj')->form();
		$szukany_tekst_testowanie = 'htmlTest' ; 
		$tekstStaly = 'Znaleziono'; //tekst wystetupje na kazdej stronie wynikow szukaj
		$htmlTestText = 'To nie powinno sie zmieniac w HTML'; //tekst ktory wystepuje na stronie htmlTest

		$form['form[text]'] = $szukany_tekst_testowanie;

		$crawler2 = $client->submit($form);

		//sprawdz czy form popralo odpowiednie wartosc
		$data = $form->getPhpValues();
		$this->assertEquals($szukany_tekst_testowanie, $data['form']['text']);

		//sprawdz czy szukaj znajduje tekst i wyswietla wyniki szukania
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/'.$tekstStaly.'/', $content);
		$this->assertRegExp('/'.$htmlTestText.'/', $content);

	}

	public function testSzukajNaStronieArtkulu()
	{
		//powtorka dla normalnej strony
		$client = static::createClient();
		$clawler = $client->request('GET', '/strona/Artykul_test');

		//zapisz nowy form
		$form = $clawler->selectButton('Szukaj')->form();
		$szukany_tekst_testowanie = 'htmlTest' ; 
		$tekstStaly = 'Znaleziono'; //tekst wystetupje na kazdej stronie wynikow szukaj
		$htmlTestText = 'To nie powinno sie zmieniac w HTML'; //tekst ktory wystepuje na stronie htmlTest

		$form['form[text]'] = $szukany_tekst_testowanie;

		$crawler2 = $client->submit($form);

		//sprawdz czy form popralo odpowiednie wartosc
		$data = $form->getPhpValues();
		$this->assertEquals($szukany_tekst_testowanie, $data['form']['text']);

		//sprawdz czy szukaj znajduje tekst i wyswietla wyniki szukania
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/'.$tekstStaly.'/', $content);
		$this->assertRegExp('/'.$htmlTestText.'/', $content);


	}
}