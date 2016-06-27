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
        $response = ['texts' => [], 'images' => [], 'videos' => []];
        $rpNotification = $rf->get('Notification');
        $notifications = $rpNotification->findNotViewNotifications();
        $auxNotification = [];
        foreach ($notifications as $currentNotification) {
            $auxNotification['id'] = $currentNotification->getPublishId();
            $auxNotification['event'] = $currentNotification->getEvent();

            switch ($currentNotification->getPublishType()) {
                case 'text':
                    $response['texts'][] = $auxNotification;
                    break;
                case 'image':
                    $response['images'][] = $auxNotification;
                    break;
                case 'videos':
                    $response['videos'][] = $auxNotification;
                    break;
            }            
        }

        return new ResponseCommandBus(200, 'Ok', $response);
    }
}