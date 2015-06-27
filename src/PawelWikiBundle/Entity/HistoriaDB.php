<?php

namespace PawelWikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * historiaDB
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class HistoriaDB
{

    public function __construct() 
    {
        // we set up "created"+"modified"
        $this->setData(new \DateTime());
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="autor", type="string", length=255)
     */
    private $autor;

    /**
     * @var string
     *
     * @ORM\Column(name="diff", type="text")
     */
    private $diff;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPoprzedniej", type="integer")
     */
    private $idPoprzedniej;

    /**
     * @var string
     *
     * @ORM\Column(name="statystyka", type="string", length=255)
     */
    private $statystyka;

    /**
     * @var string
     *
     * @ORM\Column(name="krotkiDiff", type="text")
     */
    private $krotkiDiff;


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
     * Set autor
     *
     * @param string $autor
     * @return historiaDB
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set diff
     *
     * @param string $diff
     * @return historiaDB
     */
    public function setDiff($diff)
    {
        $this->diff = $diff;

        return $this;
    }

    /**
     * Get diff
     *
     * @return string 
     */
    public function getDiff()
    {
        return $this->diff;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     * @return historiaDB
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
    *Funkcja zwraca date utworzenia w postaci stringa
    */
    public function getStringData()
    {
        return (string)$this->getData();
    }

    /**
     * Set idPoprzedniej
     *
     * @param integer $idPoprzedniej
     * @return historiaDB
     */
    public function setIdPoprzedniej($idPoprzedniej)
    {
        $this->idPoprzedniej = $idPoprzedniej;

        return $this;
    }

    /**
     * Get idPoprzedniej
     *
     * @return integer 
     */
    public function getIdPoprzedniej()
    {
        return $this->idPoprzedniej;
    }

    /**
     * Set statystyka
     *
     * @param string $statystyka
     * @return historiaDB
     */
    public function setStatystyka($statystyka)
    {
        $this->statystyka = $statystyka;

        return $this;
    }

    /**
     * Get statystyka
     *
     * @return string 
     */
    public function getStatystyka()
    {
        return $this->statystyka;
    }

    public function getArrayStatystyka()
    {
        return unserialize( $this->getStatystyka() );
    }

    /**
     * Set krotkiDiff
     *
     * @param string $krotkiDiff
     * @return historiaDB
     */
    public function setKrotkiDiff($krotkiDiff)
    {
        $this->krotkiDiff = $krotkiDiff;

        return $this;
    }

    /**
     * Get krotkiDiff
     *
     * @return string 
     */
    public function getKrotkiDiff()
    {
        return $this->krotkiDiff;
    }



    /**
    *Funkcja zwraca array zawierajacy tylko wersy ktore sie zmienily
    * @return array
    */
    public function getArrayKrotkiDiff()
    {
        return unserialize($this->getKrotkiDiff());
    }
}
