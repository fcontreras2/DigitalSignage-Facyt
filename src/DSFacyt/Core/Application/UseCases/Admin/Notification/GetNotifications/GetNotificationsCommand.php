<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Notification\GetNotifications;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtener las notificaciones del sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 3/03/2016
 */
class GetNotificationsCommand implements Command
{
    private $page;

    public function __construct($page = 1)
    {
        $this->page = $page;
    }

    public function getRequest()
    {
        return [
            'page' => $this->page
        ];
    }
}