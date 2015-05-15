<?php

namespace PawelWikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity("tytul")
 * @ORM\Table(name="artykul")
 */

/**
 *
 * Artykul
 * @ORM\Entity
 * @UniqueEntity("tytul")
 * @ORM\Table(name="artykul")
 */
class ArtykulDB
{
    /**
     * @var integer
     */
    private $id;

     /**
     * @var string
     * @ORM\Column(name="tytul", type="string", unique=true)
     */
    private $tytul;

    /**
     * @var text
     */
    private $artykul;

    /**
     * @var \DateTime
     */
    private $dataZmiany;

    /**
     * @var integer
     */
    private $idHistori;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set tytul
     *
     * @param string $tytul
     * @return tytul
     */

    public function setTytul($tytul)
    {
        $this->tytul = $tytul;

        return $this;
    }
    
    /**
     * Get tytul
     *
     * @return string 
     */
    public function getTytul()
    {
        return $this->tytul;
    }


    /**
     * Set artykul
     *
     * @param text $artykul
     * @return Artykul
     */
    public function setArtykul($artykul)
    {
        $this->artykul = $artykul;

        return $this;
    }

    /**
     * Get artykul
     *
     * @return text 
     */
    public function getArtykul()
    {
        return $this->artykul;
    }

    /**
     * Set dataZmiany
     *
     * @param \DateTime $dataZmiany
     * @return Artykul
     */
    public function setDataZmiany($dataZmiany)
    {
        $this->dataZmiany = $dataZmiany;

        return $this;
    }

    /**
     * Get dataZmiany
     *
     * @return \DateTime 
     */
    public function getDataZmiany()
    {
        return $this->dataZmiany;
    }

    /**
     * Set idHistori
     *
     * @param integer $idHistori
     * @return Artykul
     */
    public function setIdHistori($idHistori)
    {
        $this->idHistori = $idHistori;

        return $this;
    }

    /**
     * Get idHistori
     *
     * @return integer 
     */
    public function getIdHistori()
    {
        return $this->idHistori;
    }
}
