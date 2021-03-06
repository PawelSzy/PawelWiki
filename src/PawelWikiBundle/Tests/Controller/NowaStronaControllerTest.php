<?php

namespace PawelWikiBundle\Tests\Controller;

use PawelWikiBundle\Controller\Artykul;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class testNowaStrone extends WebTestCase
{
	public function testNowaStrone()
	{
		////////////////////////////////////////////////
		// Utwórz nowa strone i sprawdz czy program wyswietla
		//////////////////////////////////////////////

		$client = static::createClient();
		$clawler = $client->request('GET', '/nowy_artykul');

		//zapisz nowy form
		$form = $clawler->selectButton('Zapisz')->form();
		
		$tytul_testowanie = 'Tytul_Do_testowania' ; 
		$tresc_testowanie = "Tresc form do testowania";
		$tresc_testowanie_zmiany_tresci = "Tresc form do testowania zmiany tresc artykulu";
		$form['form[tytul]'] = $tytul_testowanie;
		$form['form[tresc]'] = $tresc_testowanie;

		$crawler2 = $client->submit($form);
	
		//sprawdz czy form popralo odpowiednie wartosc
		$data = $form->getPhpValues();
		$this->assertEquals($tytul_testowanie, $data['form']['tytul']);
		$this->assertEquals($tresc_testowanie, $data['form']['tresc']);

		//sprawdz czy zdrona zostala zapisana i mozna ja wyswietlic
		$clawler = $client->request('GET', '/strona/'.$tytul_testowanie);
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/'.$tresc_testowanie.'/', $content);

		//sprawdz edytowanie strony
		$clawler = $client->request('GET', '/edytuj/'.$tytul_testowanie);
		$form = $clawler->selectButton('Zapisz')->form();
		$form['form[tresc]'] = $tresc_testowanie_zmiany_tresci;
		$crawler2 = $client->submit($form);
		//sprawdz czy form popralo odpowiednie wartosc
		$data = $form->getPhpValues();
		$this->assertEquals($tresc_testowanie_zmiany_tresci, $data['form']['tresc']);
		//sprawdz czy edycja strony zostala zapisana i mozna ja wyswietlic
		$clawler = $client->request('GET', '/strona/'.$tytul_testowanie);
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/'.$tresc_testowanie_zmiany_tresci.'/', $content);

		//skasuj strone
		$clawler = $client->request('GET', '/skasuj/'.$tytul_testowanie);
		//sprawdz czy nie wyswietla artykulu
		$clawler = $client->request('GET', '/strona/'.$tytul_testowanie);
		$content = $client->getResponse()->getContent();
		$this->assertRegExp('/Nie znaleziono tytulu/', $content);		
	}
}