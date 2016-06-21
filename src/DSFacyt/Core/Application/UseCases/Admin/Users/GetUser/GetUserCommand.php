<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Users\GetUser;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtener los datos de un usuario'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class GetUserCommand implements Command
{
    private $userId;

    public function __construct($userId) 
    {
        $this->userId = $userId;
    }

    public function getRequest() 
    {
        return ['user_id' => $this->userId];
    }
}