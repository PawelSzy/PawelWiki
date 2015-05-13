<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArtykulDB_testController extends Controller
{


    public function testDBAction($id)
{
	echo $id;
    // $product = $this->getDoctrine()
    //     ->getRepository('ArtykulDB:ArtykulDB')
    //     ->find($id);

    // if (!$product) 
    // {
    //     throw $this->createNotFoundException(
    //         'No product found for id '.$id
    //     );
    // }
    // var_dump($product);


    // ... do something, like pass the $product object into a template
}
}
