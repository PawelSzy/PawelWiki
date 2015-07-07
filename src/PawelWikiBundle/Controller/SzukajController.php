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

                $data = array();
        // $form = $this->utworzForm($data);

       $form = $this->createFormBuilder($data, array( 'method'=>'POST', 'action' => $this->generateUrl('pawel_wiki_szukaj') ))
        ->add('text', 'text')
        ->add('Szukaj', 'submit', array( 'attr' => array("class" => "btn btn-default")) )
        ->getForm();

 //   var_dump( $this->getRequest()->query->all() );
         $form->handleRequest($request);


        if ($form->isValid() )
        {
            $data = $form->getData();
            var_dump($data);
            exit;

        }
       // if ($request->isMethod('POST')) {
       //  echo "POSTTTTTTTTTTTTTTTTTT";
       //     var_dump( $form2->handleRequest($request)); 

       //      // $data is a simply array with your form fields 
       //      // like "query" and "category" as defined above.
       //      $data = $form2->getData();
       //      var_dump($data);
       //      exit;

       //  }        


      return $this->wyswietlFormSzukaj( $form ) ; 
    }

    private function utworzForm($data)
    {
         $form = $this->createFormBuilder(array($data, 'method'=>'POST', 'action' => $this->generateUrl('pawel_wiki_szukaj'),
        'attr' => array( "class" => "form form-search", "role" => "form", ) ))
            ->add("szukaj", 'text', array( 
                'attr' => array( 'placeholder' => 'Szukaj', "class" => "span2 search-query" )))
            ->add('Zapisz', 'submit')
            ->getForm()  ;  
        return $form;     
    }


    private function wyswietlFormSzukaj( $form  )
    {
        return $this->render( 'PawelWikiBundle:Szukaj:form_szukaj.html.twig', array(
                'form' => $form->createView() ));
    }
}