<?php

namespace DSFacyt\Core\Application\UseCases\GetImportantAll;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtiene las publicaciones importante de la semana'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */
class GetImportantAllCommand implements Command
{
    public function __construct(){}

    public function getRequest() { return [];}
}
