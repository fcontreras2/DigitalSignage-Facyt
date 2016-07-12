<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Notification\GetNotifications;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;


/**
 * Clase del caso de uso 'Obtener los datos de la notificaciones del sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetNotificationsHandler implements Handler
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
     * Handler del caso de uso 'Obtener los datos de los grupos de usuarios del sistema'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpNotification = $rf->get('Notifications');
        $response = ['pagination' => [], 'notifications'=>[]];
        $notifications = $rpNotification->findBy(['view' => false]);

        $request = $command->getRequest();
        if ($notifications) {

            $response['pagination'] = $this->pagination->generate($notifications,$request['page']);
            $auxNotification = [];

            foreach ($notifications as $currentNotification) {
                $auxNotification['id'] = $currentNotification->getId();
                $auxNotification['event'] = $currentNotification->getName();
                $response['notifications'][] = $auxNotification;
            }
        }

        return new ResponseCommandBus(200,'Ok', $response);
    }
}