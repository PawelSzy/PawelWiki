<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;

class SzukajController extends Controller
{
	 use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; pobierzNazweBaze as protected;}


    public function utworzFormSzukajAction($napisyWForm = "Szukaj", Request $request)
    {
        $form = $this->createFormBuilder(array(
        'attr' => array( "class" => "form-search", "role" => "form", ) ))
            ->add("szukaj", 'text', array( 
                'attr' => array( 'placeholder' => 'Szukaj', "class" => "span2 search-query" )))
            ->getForm()  ;

        // $form->handleRequest($request);
        // if ($form->isValid()) 
        // {
        //     var_dump("odczytano szukaj!!!!!!!!!!!!!!!!!!");
        //     return;
        // }    

        return $this->wyswietlFormSzukaj( $form ) ;
    }


    private function wyswietlFormSzukaj( $form )
    {
        return $this->render( 'PawelWikiBundle:Szukaj:form_szukaj.html.twig', array(
                'form' => $form->createView() ));
    }
}