<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use DSFacyt\InfrastructureBundle\Entity\Group;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad Group
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbGroupRepository extends EntityRepository 
{
    /**
     * La siguiente función  registra un grupo
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 06/10/2015
     */
    public function save(Group $group)
    {
        $this->getEntityManager()->persist($group);
        $this->getEntityManager()->flush();
    }
}