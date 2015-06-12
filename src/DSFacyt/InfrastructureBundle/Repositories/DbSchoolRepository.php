<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use DSFacyt\Core\Domain\Model\Entity\School;
use DSFacyt\Core\Domain\Repository\SchoolRepository;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad School
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 10/06/15
*/

class DbSchoolRepository extends EntityRepository implements 
    SchoolRepository 
{
    
}