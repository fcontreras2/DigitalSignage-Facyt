<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Users\GetUsers;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;


/**
 * Clase del caso de uso 'Obtener un conjunto de usuarios por filtros'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetUsersHandler implements Handler
{
    /**
    * @var La variable contiene el servicio de paginación
    */
    private $pagination;

    /**
    * @var Método set del servicio de paginación
    */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
    * @var Método get del servicio de paginación
    */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * Handler del caso de uso 'Obtener un conjunto de usuarios por filtros'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        
        $response = [];
        $request = $command->getRequest();
        $rpUser = $rf->get('User');
        $users = $rpUser->findByFilter($request);
        if ($users) {
            
            $response['pagination'] = $this->pagination->generate($users,$request['page']);

            $response['users'] = [];
            $responseAux = [];

            foreach ($users as $currentUser) {
                $responseAux['id'] = $currentUser->getId();
                $responseAux['username'] = $currentUser->getUsername();
                $responseAux['name'] = $currentUser->getName();
                $responseAux['last_name'] = $currentUser->getLastName();
                $responseAux['identity_card'] = $currentUser->getIndentityCard();

                $responseAux['school'] = $currentUser->getSchool() ? $currentUser->getSchool()->getName() : '-';

                $responseAux['group'] = $currentUser->getGroup() ? $currentUser->getGroup()->getName() : '-';

                $response['users'][] = $responseAux;
            }
        }

        return new ResponseCommandBus(200,'Ok', $response);
    }
}