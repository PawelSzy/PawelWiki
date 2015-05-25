<?php

namespace PawelWikiBundle\Controller;

trait PobierzRepositoryTrait
{
    public function pobierzRepository()
    {
    	$artykulRepository = 'PawelWikiBundle:ArtykulDB:ArtykulDB' ;	
    	//define('artykulRepository','PawelWikiBundle:ArtykulDB:ArtykulDB');
        $repository = $this->getDoctrine()->getRepository( $artykulRepository );
        return $repository;
    }
}