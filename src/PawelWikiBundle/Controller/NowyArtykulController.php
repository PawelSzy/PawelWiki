<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\ArtykulFactory;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;


class NowyArtykulController extends Controller
{
    use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; }

    public function NowyArtykulAction( Request $request )
    {
        $repository = $this->pobierzRepository();
        $tytulNowejStrony = "Nowa strona wiki";

        $form = $this->createFormBuilder()
        ->add('tytul', 'text')
        ->add('tresc', 'text')
        ->add('Zapisz', 'submit')
        ->getForm();
   
        $form->handleRequest($request);

        if ($form->isValid()) {
            //////////////////////////////////////
            // zapis artykulu do bazu danych
            //////////////////////////////////////
            
            //odczytaj dane z form
            $arrayArtykul = array();
            $arrayArtykul["tytul"] =$form->get('tytul')->getData();
            $arrayArtykul["tresc"] =$form->get('tresc')->getData();

            //zapisz dane z form do bazy danych
            $repository = $this->pobierzRepository();
            $doctrine = $this->pobierzDoctrine();
            
            $this->ArtykulFactory = new ArtykulFactory( $repository, $doctrine );
            $artykul = $this->ArtykulFactory->nowyArtykul( $arrayArtykul ); 

            if ($artykul!== NULL)
            {
                $artykul = $this->ArtykulFactory->zapiszArtykul( $artykul );
                $this->redirectToRoute('strona/'.$artykul->odczytajTytul());
            }
        }
        return $this->render( 'PawelWikiBundle:Default:nowa_strona.html.twig', array('tytul' => $tytulNowejStrony,
                'form' => $form->createView() )
        );
    }
}