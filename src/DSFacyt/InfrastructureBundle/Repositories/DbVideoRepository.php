<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use DSFacyt\Core\Domain\Model\Entity\Video;
use DSFacyt\Core\Domain\Repository\VideoRepository;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad Video
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbVideoRepository extends EntityRepository implements 
    VideoRepository 
{
    
}