<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Users\GetUser;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\User;

/**
 * Clase del caso de uso 'Obtener los datos de un usuario'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetUserHandler implements Handler
{
    /**
     * Handler del caso de uso 'Obtener los datos de un usuario'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpUser = $rf->get('User');
        $data = $command->getRequest();
        $response = [];

        $user = $rpUser->findOneBy(['id' => $data['user_id']]);

        if ($user) {

            $response['id'] = $user->getId();
            $response['username'] = $user->getUserName();
            $response['name'] = $user->getName();
            $response['email'] = $user->getEmail();
            $response['last_name'] = $user->getLastName();
            $response['identity_card'] = $user->getIndentityCard();            
            $school = $user->getSchool();
            $response['school'] = [];            
            if ($school){                
                $response['school']['id'] = $school->getId();
                $response['school']['name'] = $school->getName();
            }                

            $group = $user->getGroup();
            $response['group'] = [];
            if ($group) {
                $response['group']['id'] = $group->getId();
                $response['group']['name'] = $group->getName();
            }

            return new ResponseCommandBus(200,'Ok', $response);
        }

        return new ResponseCommandBus(404,'Not Found');
    }
}