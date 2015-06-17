<?php

namespace PawelWikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

 use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Autor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PawelWikiBundle\Entity\AutorRepository")
 */
class AutorDB implements UserInterface
{
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
     * @ORM\Column(name="login", type="string", length=255)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="passwordHash", type="string", length=255)
     */
    private $passwordHash;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;


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
     * Set login
     *
     * @param string $login
     * @return Autor
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    public function getUsername()
    {
        return $this->login;
    }


    public function setUsername($login)
    {
        $this->login = $login;

        return $this;
    }
    /**
     * Set passwordHash
     *
     * @param string $passwordHash
     * @return Autor
     */
    public function setPassword($password)
    {
        $this->passwordHash = password_hash( $password, PASSWORD_BCRYPT );

        return $this;
    }

    /**
     * Get passwordHash
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->passwordHash;
    }

    public function getHaslo()
    {
        return $this->passwordHash;
    }

    public function setHaslo($password)
    {
        return $this->setPassword($password);
    }    

    public function setPasswordHash($password)
    {
        $this->passwordHash = password_hash( $password, PASSWORD_BCRYPT );

        return $this;
    }


    /**
     * Get passwordHash
     *
     * @return string 
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Autor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getSalt() 
    {
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {

    }

}
