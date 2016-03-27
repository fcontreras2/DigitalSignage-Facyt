<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use DSFacyt\InfrastructureBundle\Entity\Document;
use DSFacyt\Core\Domain\Repository\DocumentRepository;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad Document
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbDocumentRepository extends EntityRepository implements 
    DocumentRepository  
{
    
}