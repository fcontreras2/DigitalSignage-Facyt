<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Publish\UpdateImportant;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso UpdateImportant
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 */

class UpdateImportantHandler implements Handler
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
     * Ejecuta el caso de uso 'Eliminar la imagen'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $data = $command->getRequest();

        //try {
            $rpPublishType = $rf->get($data['type']);
            $publish = $rpPublishType->find($data['publishId']);
            
            if ($publish) {
                $publish->setImportant($data['important']);
                $rpPublishType->save($publish);
            }

            return new ResponseCommandBus(200, 'Ok');
        /*} catch (\Exception $e) {
            return new ResponseCommandBus(500, $e->getmessage() );        
        }*/
    }
}