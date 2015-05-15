<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArtykulDBController extends Controller
{


    public function testDBAction($id)
    {
	echo "id: ".$id."\n";
    
    $product = $this->getDoctrine()
        ->getRepository('PawelWikiBundle:ArtykulDB:ArtykulDB')
        ->find($id);

    if (!$product) 
    {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }
    var_dump($product);
    return $this->render('PawelWikiBundle:Default:index.html.twig', array('name' => $id));

    // ... do something, like pass the $product object into a template
    }
}
