<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Users\SetUser;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\User;

/**
 * Clase para ejecutar el caso de Editar o crear un usuario
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class SetUserHandler implements Handler
{

    private $email;

    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Ejecuta el caso de uso 'Editar o crear un usuario'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpUser = $rf->get('User');
        $rpSchool = $rf->get('School');
        $rpGroup = $rf->get('Group');
        $data = $command->getRequest()['data'];
        $user = isset($data['id']) ? 
            $rpUser->findOneBy(['id' => $data['id']]):
            new User();

        if ($user) {
            
            $user->setUserName($data['username']);            
            if (isset($data['password']))
                $user->setPlainPassword($data['password']);
            $user->setName($data['name']);
            $user->setEmail($data['email']);
            $user->setLastName($data['last_name']);
            $user->setEnabled(true);
            $user->setIndentityCard($data['identity_card']);

            $school = $rpSchool->findOneBy(['id' => $data['school']['id']]);

            if ($school)
                $user->setSchool($school);

            $group = $rpGroup->findOneBy(['id' => $data['group']['id']]);

            if ($group) {
                $user->setGroup($group);
                $group->addUser($user);
            }

            $rpUser->save($user);
            $data['new'] = !isset($data['id']) ? true : false;

            $this->email->setRecipients(array($data['email']));
            if ($data['new'])
                $this->email->setSubject('Bienvenido, creación de usuario - DSFacyt');
            else
                $this->email->setSubject('Actualizanción de datos - DSFacyt');                

            $this->email->setViewRender('DSFacytInfrastructureBundle:Email:newEditUser.html.twig');
            $this->email->setViewParameters($data);
            $this->email->setEmailSender('ds_facyt@uc.edu.ve');
            $this->email->sendEmail();

            return new ResponseCommandBus(201,'Created');
        }

        return new ResponseCommandBus(404,'Not Found');
    }
}