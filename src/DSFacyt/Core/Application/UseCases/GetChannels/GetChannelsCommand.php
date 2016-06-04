<?php

namespace DSFacyt\Core\Application\UseCases\GetChannels;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtiene la información de todos los canales'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */
class GetChannelsCommand implements Command
{
    public function __construct() {}

    public function getRequest()
    {
        return [];
    }
}
