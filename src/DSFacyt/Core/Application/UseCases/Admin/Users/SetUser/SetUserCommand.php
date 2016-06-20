<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Users\SetUser;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Editar o Crear un usuario'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class SetUserCommand implements Command
{
    private $data;

    public function __construct($data) 
    {
        $this->data = $data;
    }

    public function getRequest() 
    {
        return ['data' => $this->data];
    }
}