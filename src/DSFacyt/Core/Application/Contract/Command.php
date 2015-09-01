<?php

namespace DSFacyt\Core\Application\Contract;

/**
 * Interface Command modela las funciones que obligatoriamente deben implementarse en un Commando
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31-08-2015
 */
interface Command
{
    /**
     *  Método getRequest devuelve un array con los parametros del command
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31-08-2015
     * @return  Array
     */
    public function getRequest();
}