<?php

namespace PawelWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PawelWikiBundle:Default:index.html.twig', array('name' => $name));
    }


    // ... do something, like pass the $product object into a template

}
