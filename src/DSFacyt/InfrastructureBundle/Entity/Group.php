<?php 

namespace DSFacyt\InfrastructureBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;

use DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
 * La clase se encarga de manejar los usuarios del sistema
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31-05-15
 */
class Group extends BaseGroup
{
   	
    /**
     * Constructor
     */
    public function __construct(){}
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;


    /**
     * Add users
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Image $users
     * @return Group
     */
    public function addUser(\DSFacyt\InfrastructureBundle\Entity\Image $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Image $users
     */
    public function removeUser(\DSFacyt\InfrastructureBundle\Entity\Image $users)
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
