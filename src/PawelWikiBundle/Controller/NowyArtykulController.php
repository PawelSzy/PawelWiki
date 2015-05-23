<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\ArtykulFactory;

use Symfony\Component\HttpFoundation\Request;

define('artykulRepository','PawelWikiBundle:ArtykulDB:ArtykulDB');

class NowyArtykulController extends Controller
{

    private function pobierzRepository()
    {
        $repository = $this->getDoctrine()->getRepository( artykulRepository );
        return $repository;
    }

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
            // perform some action, such as saving the task to the database
            $arrayArtykul = array();
            $arrayArtykul["tytul"] =$form->get('tytul')->getData();
            $arrayArtykul["tresc"] =$form->get('tresc')->getData();

            $repository = $this->pobierzRepository();
            
            $this->ArtykulFactory = new ArtykulFactory( $repository );
            $artykul = $this->ArtykulFactory->nowyArtykul( $arrayArtykul ); 

            if ($artykul!== NULL){
                var_dump($artykul);
            }    

            // return $this->redirect($this->generateUrl('task_success'));
        }

        return $this->render( 'PawelWikiBundle:Default:nowa_strona.html.twig', array('tytul' => $tytulNowejStrony,
                'form' => $form->createView() )
        );
    }
}