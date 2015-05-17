<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WyswietlStroneController extends Controller
{


    public function WyswietlStroneAction($tytul)
    {
	echo "tytul: ".$tytul."\n";

    $product = $this->getDoctrine()->getRepository('PawelWikiBundle:ArtykulDB:ArtykulDB')->findOneBy(array('tytul' => $tytul));
    
    // $product = $this->getDoctrine()
    //     ->getRepository('PawelWikiBundle:ArtykulDB:ArtykulDB')
    //     ->find($id);

    if (!$product) 
    {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }
    var_dump($product);
    return $this->render('PawelWikiBundle:Default:index.html.twig', array('name' => $tytul));

    // ... do something, like pass the $product object into a template
    }
}
