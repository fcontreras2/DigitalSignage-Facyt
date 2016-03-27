<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use DSFacyt\InfrastructureBundle\Entity\User;
use DSFacyt\Core\Domain\Repository\UserRepository;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad User
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbUserRepository extends EntityRepository implements 
    UserRepository  
{
    /**
     * La siguiente función  registra un usuario
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 06/10/2015
     */
    public function save(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}