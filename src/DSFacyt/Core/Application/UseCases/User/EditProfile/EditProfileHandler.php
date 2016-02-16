<?php

namespace DSFacyt\Core\Application\UseCases\User\EditProfile;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso EditProfile
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/09/2015
 */

class EditProfileHandler implements Handler
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
       // try {
            $data = $command->getRequest();

            $editData = $data['data'];
            $user = $data['user'];

            if (isset($editData['identity_card']))
                $user->setIndentityCard($editData['identity_card']);

            if (isset($editData['name']))
                $user->setName($editData['name']);

            if (isset($editData['last_name']))
                $user->setLastName($editData['last_name']);

            if (isset($editData['school_id'])) {
                $rpSchool = $rf->get('School');
                $school = $rpSchool->findOneBy(
                    [ 'id' => $editData['school_id']]);

                if ($school)
                    $user->setSchool($school);
            }

            if (isset($editData['phone']))
                $user->setPhone($editData['phone']);

            $rpUser = $rf->get('User');

            $rpUser->save($user);

            return new ResponseCommandBus(200,'Ok');

        //} catch (\Exception $e) {
          //  return new ResponseCommandBus(500,$e->getMessage());
        //}

    }
}