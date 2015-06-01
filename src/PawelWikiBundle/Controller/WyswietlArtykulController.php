<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;

class WyswietlArtykulController extends Controller
{

    use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; pobierzNazweBaze as protected;}

    public function WyswietlArtykulAction( $tytul )
    {
    $repository = $this->pobierzRepository();
    $doctrine = $this->pobierzDoctrine();

    $this->BazaArtykulow = new BazaArtykulow( $repository, $doctrine );
    $artykul = $this->BazaArtykulow->odczytajArtykul( $tytul );

    return $this->wyswietlArtykul( $artykul );
    }


    public function NowyArtykulAction( Request $request )
    {
        $repository = $this->pobierzRepository();
        $tytulNowejStrony = "Nowa strona wiki";

        $form = $this->utworzFormZapisu();

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

            $this->BazaArtykulow = new BazaArtykulow( $repository, $doctrine );
            $artykul = $this->BazaArtykulow->nowyArtykul( $arrayArtykul );

            if ($artykul!== NULL)
            {
                $tytulArtykulu = $artykul->odczytajTytul();
                if( !$this->BazaArtykulow->czyIstniejeTytul( $tytulArtykulu ))
                {
                    $artykul = $this->BazaArtykulow->zapiszNowyArtykul( $artykul );
                    return $this->redirectToRoute('pawel_wiki_artykul', array('tytul' => $artykul->odczytajTytul() ));
                }
                else {
                    return $this->wyswietlStronaIstnieje( $tytulArtykulu );
                }

            }
        }
        return $this->wyswietlStroneForm($tytulNowejStrony, $form); 
    }

    public function edytujArtykulAction( $tytul, Request $request)
    {
        $repository = $this->pobierzRepository();
        $tytulNowejStrony = "Edytuj strone PawelWiki";


        $this->BazaArtykulow = new BazaArtykulow( $this->pobierzRepository(), $this->pobierzDoctrine() );
        $artykul = $this->BazaArtykulow->odczytajArtykul( $tytul );


        if ($artykul!== NULL)
        {             
           //utworz Form i wpisz do niego tresc z artykulu
            $textWForm = array('tytul' => $artykul->odczytajTytul(), 'tresc' => $artykul->odczytajTresc() );
            $form = $this->utworzFormZapisu($textWForm);
            $form->handleRequest($request);
           if ($form->isValid()) 
           {
                //////////////////////////////////////
                // zapis artykulu do bazu danych
                //////////////////////////////////////

                //odczytaj dane z form
                //$arrayArtykul["tytul"] =$form->get('tytul')->getData();
                $artykul->zmienTytul( $form->get('tytul')->getData() );
                $artykul->zmienTresc( $form->get('tresc')->getData() );
                $artykul = $this->BazaArtykulow->edytujArtykul( $artykul );                
                if ($artykul!== NULL)
                {
                    //zapisz artykul
                    return $this->redirectToRoute('pawel_wiki_artykul', array('tytul' => $artykul->odczytajTytul() ));
                }
            }
        }        
        return $this->wyswietlStroneForm($tytulNowejStrony, $form); 
    }

    public function SkasujArtykulAction( $tytul )
    {
        $BazaArtykulow = new BazaArtykulow( $this->pobierzRepository(), $this->pobierzDoctrine() );
        $BazaArtykulow->skasujArtykul( $tytul );
        $wiadomosc ="Skasowano artykul o nazwie: ".$tytul;
        $tytul_strony = "PawelWiki Skasowano strone";
        return $this->wyswietlWiadomosc( $wiadomosc, $tytul_strony);
    }
    
    private function utworzFormZapisu($napisyWForm = NULL)
    {
        $form = $this->createFormBuilder($napisyWForm)
        ->add('tytul', 'text')
        ->add('tresc', 'text')
        ->add('Zapisz', 'submit')
        ->getForm();
        return $form;
    }

    private function wyswietlArtykul( $artykul )
    {
        return $this->render( 'PawelWikiBundle:Default:artykul.html.twig', array('tytul' => $artykul->odczytajTytul(),
            'tresc' => $artykul->odczytajTresc() )) ;        
    }

    private function wyswietlStroneForm($tytulNowejStrony, $form)
    {
        return $this->render( 'PawelWikiBundle:Default:nowa_strona.html.twig', array('tytul' => $tytulNowejStrony,
                'form' => $form->createView() ));
    }
    private function wyswietlStronaIstnieje( $tytul )
    {
        $blad = 'Istnieje juz artykul o nazwie: '.$tytul;
        $tytul_strony = 'PawelWikiBlad';
        return $this->render( 'PawelWikiBundle:Default:informacje_o_bledzie.html.twig', array('blad' => $blad,
            'tytul' => $tytul_strony));

    }

    private function wyswietlWiadomosc( $wiadomosc, $tytul_strony = "PawelWiki Wiadomosc")
    {
        return $this->render( 'PawelWikiBundle:Default:wiadomosc.html.twig', array('wiadomosc' => $wiadomosc,
            'tytul' => $tytul_strony));
    }

}