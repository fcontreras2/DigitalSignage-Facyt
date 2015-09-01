<?php

namespace DSFacyt\Core\Application\Contract;

/**
 *	Interface RepositoryFactory modela un servicio usado por el commandBus y los handler para obtener
 *	determinados repositorios en el momento que sean requeridos
 *
 *  @author Freddy Contreras <freddycontreras3@gmail.com>
 *  @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 *	@version 31/08/2015
 */
interface RepositoryFactoryInterface
{
    /**
     *	Devuelve el objeto repoisitorio de la entidad que se pasa por parametro
     *
     *	@author: Freddy Contreras <freddycontreras3@gmail.com>
     *	@author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     *	@return Entity
     *	@version 31/08/2015
     *	@param String
     *	@return EntityRepository
     */
    public function get($entity);
}