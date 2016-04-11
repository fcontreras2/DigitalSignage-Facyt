<?php

namespace DSFacyt\Core\Application\UseCases\User\GetProfile;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetProfile
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/09/2015
 */

class GetProfileHandler implements Handler
{
    /**
     * @var Representa el comando de la clase
     */
    private $command;

    /**
     * @var Representa la RepositorioFactory de la clase
     */
    private $rf;

    /**
     * Ejecuta el caso de uso 'Obtener todas los textos publicados por un usuario'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $userResquest = $command->getRequest()['user'];
        $response = array();
        $rpUser = $rf->get('User');
        $user = $rpUser->findOneBy(array('id' => $userResquest));

        if ($user) {
            $response['id'] = $user->getId();
            $response['profile_image'] = $user->getImageProfile()->getFileName();
            $response['user_name'] = $user->getUserName();
            $response['identity_card'] = $user->getIndentityCard();
            $response['email'] = $user->getEmail();
            $response['name'] = $user->getName();
            $response['last_name'] = $user->getLastName();
            $response['phone'] = $user->getPhone();
            $response['rol'] = $user->getRoles();
            $response['profile_image'] = $user->getImageProfile() ?
                $user->getImageProfile()->getFileName() : '/images/avatar.jpg';
            $response['school'] = $user->getSchool()->getName();
            $response['school_id'] = $user->getSchool()->getId();

            $response['all_school'] = [];
            $schools  =  $rf->get('School')->findBy(array(), array('name' => 'ASC'));
            foreach ($schools as $currentSchool) {
                $auxSchool = [];
                $auxSchool['id'] = $currentSchool->getId();
                $auxSchool['name'] = $currentSchool->getName();
                array_push($response['all_school'], $auxSchool);
            }

            return new ResponseCommandBus(201, 'Ok', $response);
        } else
            return new ResponseCommandBus(404,'Not Found');



    }
}