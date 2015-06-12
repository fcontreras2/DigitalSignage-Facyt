<?php

namespace DSFacyt\Core\Domain\Model\Entity;

use \DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
* La clase se encarga del manejo de los escuelas o carrera de la facultad
* 
* @author Freddy Contreras <freddycontreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
* @version 10-06-15
*/
class School
{
    /**
     * Esta propiedad es usada como llave primaria dentro de la DB.
     * 
     * @var Integer
     */
    private $id;
    
    /**
     * Esta propiedad refleja el titulo del Canal
     * 
     * @var String
     */
    private $name;

    /**
     * Esta propiedad refleja la descripción del Canal
     * 
     * @var String
     */
    private $description;

     /**
     * Esta propiedad refleja los usuarios asociados a la escuela/ carrera
     * 
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $users;

    public function __construct() 
    { 
        $this->users = new ArrayCollection();        
    }


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
     * Set name
     *
     * @param string $name
     * @return School
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return School
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add users
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\User $users
     * @return School
     */
    public function addUser(\DSFacyt\Core\Domain\Model\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\User $users
     */
    public function removeUser(\DSFacyt\Core\Domain\Model\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
