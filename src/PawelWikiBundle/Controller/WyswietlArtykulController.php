<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\ArtykulFactory;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;

class WyswietlArtykulController extends Controller
{

    use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; pobierzNazweBaze as protected;}

    public function WyswietlArtykulAction( $tytul )
    {
    $repository = $this->pobierzRepository();
    $doctrine = $this->pobierzDoctrine();
    
    $this->ArtykulFactory = new ArtykulFactory( $repository, $doctrine );
    $artykul = $this->ArtykulFactory->odczytajArtykul( $tytul ); 

    return $this->render( 'PawelWikiBundle:Default:artykul.html.twig', array('tytul' => $artykul->odczytajTytul(),
            'tresc' => $artykul->odczytajTresc()
        ));
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
                $tytulArtykulu = $artykul->odczytajTytul();
                if( $this->ArtykulFactory->czyIstniejeTytul( $tytulArtykulu ))
                {
                    $artykul = $this->ArtykulFactory->zapiszNowyArtykul( $artykul );
                    return $this->redirectToRoute('pawel_wiki_artykul', array('tytul' => $artykul->odczytajTytul() ));                   
                }
                else {
                    return $this->wyswietlStronaIstnieje( $tytulArtykulu );
                }

            }
        }
        return $this->render( 'PawelWikiBundle:Default:nowa_strona.html.twig', array('tytul' => $tytulNowejStrony,
                'form' => $form->createView() )
        );
    }

    private function wyswietlStronaIstnieje( $tytul )
    {
        $blad = 'Istnieje juz artykul o nazwie: '.$tytul;
        $tytulStrony = 'PawelWikiBlad';
        return $this->render( 'PawelWikiBundle:Default:informacje_o_bledzie.html.twig', array('blad' => $blad,
            'tytul' => $tytulStrony));
        
    }

}