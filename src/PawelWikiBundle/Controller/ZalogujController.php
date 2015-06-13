<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;

class ZalogujController extends Controller 
{
	public function nowy_autorAction()
    {	

        $tytul = "Nowy autor PawelWiki";
        $form = $this->utworzForm();
        return $this->wyswietlNowyAutor($tytul, $form);
    }

    private function utworzForm($napisyWForm = NULL)
    {

        $form = $this->createFormBuilder($napisyWForm)
        ->add('Login', 'text')
        ->add('haslo', 'password')
        ->add('email', 'email')
        ->add('Zapisz', 'submit')
        ->getForm();
        return $form;
    
    }

    private function wyswietlNowyAutor($tytul, $form)
    {
        return $this->render('PawelWikiBundle:Default:nowy_autor.html.twig', array('tytul' => $tytul, 'form' => $form->createView() ));
    }
}