<?php

namespace DSFacyt\Core\Application\UseCases\User\SetImageProfile;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\Document;

/**
 * Clase para ejecutar el caso de uso SetImageProfile
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/09/2015
 */

class SetImageProfileHandler implements Handler
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
     * Ejecuta el caso de uso 'Asignar la imagen de perfil del usuario'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $request = $command->getRequest();

        $user = $request['user'];
        $image = $request['image'];

        try{

            $rpUser = $rf->get('User');
            $path = $user->getIndentityCard();
            $document = new Document();
            $document->setFile($image);
            $document->setName('profile');
            $document->upload('image', $path.'/',$path.'_profile');      
            $user->setImageProfile($document);
            $rpUser->save($user);

            return new ResponseCommandBus(200,'Ok');

        } catch (\Exception $e) {
            return new ResponseCommandBus(500,'Error Servidor');
        }           
        
    }    
}