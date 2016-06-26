<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Notification\CheckNotification;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso 'Verificación de las notificaciones'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class CheckNotificationHandler implements Handler
{
    /**
     * Ejecute el caso de uso "Verificación de las notificacíones"
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $response = [];
        $rpNotification = $rf->get('Notification');
        

        return new ResponseCommandBus(200, 'Ok', $response);
    }
}