<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\autor\BazaAutorow;

require_once('RepositoryTraitAutorow.php');

use Symfony\Component\HttpFoundation\Request;

class ZalogujController extends Controller 
{

     use RepositoryTraitAutorow { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; pobierzNazweBaze as protected;}
	public function nowy_autorAction( Request $request )
    {

        $repository = $this->pobierzRepository();
        $doctrine = $this->pobierzDoctrine();

        $bazaAutorow = new BazaAutorow( $repository, $doctrine );


        ///////////test///////////////////////////////////////////////////////
        $autor = $bazaAutorow->odczytajAutora( "test" );
        var_dump( $autor );
        ///////////test koniec///////////////////////////////////////////////////////
      
        $form = $this->utworzForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            //////////////////////////////////////
            // zapis artykulu do bazu danych
            //////////////////////////////////////

            //odczytaj dane z form
            $arrayArtykul = array();
            $arrayArtykul["tytul"] =    $form->get('login')->getData();
            $arrayArtykul["haslo"] = $form->get('haslo')->getData();
            $arrayArtykul["email"] =    $form->get('email')->getData(); 

            $user = new AppBundle\Entity\User();
            // $plainPassword = 'ryanpass';
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user,  $arrayArtykul["haslo"]);

            var_dump( $encoded);
            $user->setPassword($encoded);
            /////////////////////////////////TUTAJ DODAJ ZAPIS DO BAZY DANYCH////////////////////////////////////////////////////        
        }    
   
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