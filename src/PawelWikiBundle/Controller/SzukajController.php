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


    public function utworzFormSzukajAction(Request $request)
    {
        //utworz form
        $data = array();
        $form = $this->utworzForm($data);

        //odczytaj form
        $form->handleRequest($request);
        if ($form->isValid() )
        {
            $data = $form->getData();
            $szukanyTekst = $data['text'];
            $wyszukaneArtykuly = $this->szukajWBazieDanych( $szukanyTekst );
            var_dump($wyszukaneArtykuly);
            return $this->wyswietlStroneZnaleziono( $wyszukaneArtykuly, $szukanyTekst);

        }

      return $this->wyswietlFormSzukaj( $form ) ; 
    }

    private function szukajWBazieDanych( $szukaj )
    {
        $BazaArtykulow = new BazaArtykulow( $this->pobierzRepository(), $this->pobierzDoctrine() );
        $wyszukaneArtykuly = $BazaArtykulow->szukajWBazieDanych( $szukaj );     
        return $wyszukaneArtykuly;        
    }

    private function utworzForm($data)
    {
       $form = $this->createFormBuilder($data, array( 'method'=>'POST', 'action' => $this->generateUrl('pawel_wiki_szukaj') ))
        ->add('text', 'text')
        ->add('Szukaj', 'submit', array( 'attr' => array("class" => "btn btn-default")) )
        ->getForm();
        return $form;
    }    

    private function wyswietlStroneZnaleziono( $artykuly, $szukanyTekst)
    {
        return $this->render( 'PawelWikiBundle:Szukaj:szukaj_wiki_strona.html.twig', array('tytul' => $szukanyTekst, 'artykuly' => $artykuly) ); 
    }


    private function wyswietlFormSzukaj( $form  )
    {
        return $this->render( 'PawelWikiBundle:Szukaj:form_szukaj.html.twig', array(
                'form' => $form->createView() ));
    }
}