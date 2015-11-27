<?php

namespace DSFacyt\InfrastructureBundle\Resources\Services;

use DSFacyt\Core\Application\Contract\PaginationInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use DSFacyt\InfrastructureBundle\Repositories\DbCancellationPolicyRepository;


/**
 *	Clase RepositoryFactory modela un servicio usado por el commandBus y los handler para obtener
 *	determinados repositorios en el momento que sean requeridos
 *	@author Freddy Contreras <freddycontreras3@gmail.com>
 *	@author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 *	@version 31/08/2015
 */
class Pagination implements PaginationInterface
{
    public $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public static function generate($data, $page, $pagination = this)
    {
        $pagination = $paginator->get('knp_paginator')->paginate(
            $data, 
            $request->query->getInt('page', 1),
            8
        );

        return $pagination;
    }

    

}