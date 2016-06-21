<?php 

namespace DSFacyt\InfrastructureBundle\Entity;

use DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
 * La clase se encarga de manejar los usuarios del sistema
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31-05-15
 */
class Group 
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $defaults_permisions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set defaults_permisions
     *
     * @param array $defaultsPermisions
     * @return Group
     */
    public function setDefaultsPermisions($defaultsPermisions)
    {
        $this->defaults_permisions = $defaultsPermisions;

        return $this;
    }

    /**
     * Get defaults_permisions
     *
     * @return array 
     */
    public function getDefaultsPermisions()
    {
        return $this->defaults_permisions;
    }

    /**
     * Add users
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\User $users
     * @return Group
     */
    public function addUser(\DSFacyt\InfrastructureBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\User $users
     */
    public function removeUser(\DSFacyt\InfrastructureBundle\Entity\User $users)
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
    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Group
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
}
