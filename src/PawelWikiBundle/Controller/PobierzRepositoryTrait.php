<?php

namespace PawelWikiBundle\Controller;

trait PobierzRepositoryTrait
{

    public function pobierzNazweBaze()
    {
        $nazwa_bazy = 'PawelWikiBundle:ArtykulDB:ArtykulDB' ;
        return $nazwa_bazy;
    }


    public function pobierzAdresBazyDanych()
    {
        $adresBazyDanych =' PawelWikiBundle\Entity\ArtykulDB';
        return $adresBazyDanych;
    }
	
    public function pobierzAdresBazyHistori()
    {
        $adresBazyDanych =' PawelWikiBundle\Entity\HistoriaDB';
        return $adresBazyDanych;
    }

    public function pobierzRepository()
    {
    	$nazwa_bazy = $this->pobierzNazweBaze();
    	//define('artykulRepository','PawelWikiBundle:ArtykulDB:ArtykulDB');
        $repository = $this->getDoctrine()->getRepository( $nazwa_bazy );
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