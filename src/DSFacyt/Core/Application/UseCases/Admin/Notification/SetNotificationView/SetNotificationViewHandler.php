<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Notification\SetNotificationView;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;


/**
 * Clase del caso de uso 'Modificar la notificación como vista'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class SetNotificationViewHandler implements Handler
{
    /**
     * Handler del caso de uso 'Obtener los datos de los grupos de usuarios del sistema'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpNotification = $rf->get('Notification');
        $notification = $rpNotification->findOneBy(['id' => $command->getRequest()['id']]);

        if ($notification) {
            $notification->setView(true);
            $rpNotification->save($notification);
            return new ResponseCommandBus(200,'Ok');
        }

        return new ResponseCommandBus(404, 'Not Found');
    }
}