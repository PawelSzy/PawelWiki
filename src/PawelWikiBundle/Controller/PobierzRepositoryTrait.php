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

    public function pobierzDoctrine()
    {
		$doctrine = $this->getDoctrine();
        return $doctrine;
    }

    public function pobierzMenager()
    {
    	$menager = $this->getDoctrine()->getManager();
    	return $menager;
    }
}