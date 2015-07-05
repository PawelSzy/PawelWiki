<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use PawelWikiBundle\Controller\BazaArtykulow;

require_once('PobierzRepositoryTrait.php');

use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;

class WyswietlStroneController extends Controller
{
	 use PobierzRepositoryTrait { pobierzRepository as protected; pobierzDoctrine as protected; pobierzMenager as protected; pobierzNazweBaze as protected;}

    public function WyswietlStroneAction($tytul)
    {
        
        return $this->WyswietlStroneArtykul( $tytul );
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
            $user = $this->pobierzUzytkownika();
            

            $this->BazaArtykulow = new BazaArtykulow( $repository, $doctrine, $user);
            $artykul = $this->BazaArtykulow->nowyArtykul( $arrayArtykul );

            if ($artykul!== NULL)
            {
                $tytulArtykulu = $artykul->odczytajTytul();
                if( !$this->BazaArtykulow->czyIstniejeTytul( $tytulArtykulu ))
                {
                    $artykul = $this->BazaArtykulow->zapiszNowyArtykul( $artykul );
                    return $this->przeniescDoStrony( $artykul->odczytajTytul() );;
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
        $tytulNowejStrony = $tytul;
        $user = $this->pobierzUzytkownika();
       


        $this->BazaArtykulow = new BazaArtykulow( $this->pobierzRepository(), $this->pobierzDoctrine(), $user );
        $artykul = $this->BazaArtykulow->odczytajArtykul( $tytul );


        if ($artykul!== NULL)
        {             
           //utworz Form i wpisz do niego tresc z artykulu
            $textWForm = array('tytul' => $artykul->odczytajTytul(), 'tresc' => $artykul->odczytajTresc() );
            $form = $this->utworzEdytujForm($textWForm);
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
                $czyNowyArtykul = $form->get('utworzNowyArtykul')->getData();
                if ( $czyNowyArtykul){
                    $artykul = $this->BazaArtykulow->zapiszNowyArtykul( $artykul );
                }
                else {
                    $artykul = $this->BazaArtykulow->edytujArtykul( $artykul );              
                }
                $tytulNowejStrony = $artykul->odczytajTytul(); 
                
                if ($artykul!== NULL)
                {
                    //zapisz artykul
                    return $this->przeniescDoStrony( $artykul->odczytajTytul() );
                }
            }
        }  
             
        return $this->wyswietlStroneEdytuj($tytulNowejStrony, $form); 
    }

  	private function utworzFormZapisu($napisyWForm = NULL)
    {
        $form = $this->createFormBuilder($napisyWForm)
        ->add('tytul', 'text')
        ->add('tresc', 'textarea')
        ->add('Zapisz', 'submit')
        ->getForm();
        return $form;
    } 

    private function utworzEdytujForm($napisyWForm = NULL)
    {
        $form = $this->createFormBuilder($napisyWForm, array(
      'attr' => array( "class" => "form", "role" => "form", ) ))
        ->add('tytul', 'text')
        ->add('utworzNowyArtykul', 'checkbox', array('label'=> 'Zaznacz aby utworzyc nowy artykul',
                'required'  => false,
        ))        
        ->add('tresc', 'textarea')
        ->add('Zapisz', 'submit')
        ->getForm();
        return $form;
    } 



    private function przeniescDoStrony( $tytul )
    {
    	return $this->redirectToRoute('pawel_wiki_strona', array('tytul' => $tytul ));
    }

    private function wyswietlStronaIstnieje( $tytul )
    {
        $blad = 'Istnieje juz artykul o nazwie: '.$tytul;
        $tytul_strony = 'PawelWikiBlad';
        return $this->render( 'PawelWikiBundle:Default:informacje_o_bledzie.html.twig', array('blad' => $blad,
            'tytul' => $tytul_strony));
    }


    private function WyswietlStroneArtykul($tytul)
    {
        
        return $this->render('PawelWikiBundle:Default:wiki_strona.html.twig', array('tytul' => $tytul));
    }   
    
    private function wyswietlStroneForm($tytulNowejStrony, $form)
    {
        return $this->render( 'PawelWikiBundle:Default:nowa_strona.html.twig', array('tytul' => $tytulNowejStrony,
                'form' => $form->createView() ));
    }

    private function wyswietlStroneEdytuj($tytulNowejStrony, $form)
    {
        return $this->render( 'PawelWikiBundle:Default:edytuj_strone.html.twig', array('tytul' => $tytulNowejStrony,
                'form' => $form->createView() ));
    }


    private function pobierzUzytkownika()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser() ;

        if ( $user != 'anon.'){
            $userName = $user->getLogin(); 
        }
        else {
            $userName = $user;
        }
        return $userName;
    }





}
