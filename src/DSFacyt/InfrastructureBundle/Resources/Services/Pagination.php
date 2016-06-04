<?php

namespace DSFacyt\InfrastructureBundle\Resources\Services;

use DSFacyt\Core\Application\Contract\PaginationInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use DSFacyt\InfrastructureBundle\Repositories\DbCancellationPolicyRepository;


/**
 *	Clase Pagination modela un servicio usado por el commandBus y los handler 
 *  para realizar la paginación de los resultados
 *
 *	@author Freddy Contreras <freddycontreras3@gmail.com>
 *	@author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 *	@version 31/08/2015
 */
class Pagination implements PaginationInterface
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
    * La siguiente función aplica la paginación de un conjunto de datos
    * 
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @version 02/12/2015
    * @return array 
    */
    public function generate(&$data, $numberPage, $numberItems = 10)
    {

        if (count($data) > $numberItems) {
            $paginator  = $this->container->get('knp_paginator');
            $pagination = $paginator->paginate(
                $data,
                $numberPage/*page number*/,
                $numberItems/*limit per page*/
            );

            $data = $pagination->getItems();
            
            return $pagination->getPaginationData();
        } else {
            return 0;
        }
    }
}