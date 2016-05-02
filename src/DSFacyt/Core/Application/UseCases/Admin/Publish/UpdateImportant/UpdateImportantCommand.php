<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Publish\UpdateImportant;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Actualiza una publicación como destacado'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 */

class UpdateImportantCommand implements Command
{
    /**
     * @var string Representa el tipo de publicación a buscar (texto, imagen o video)
     */
    private $type;

    /**
     * @var boolean representa si es ac
     */
    private $important;

    /**
    * @var integer id de la publicación 
    */

    public function __construct($type, $important, $publishId)
    {
        $this->type = $type;
        $this->important = $important;
        $this->publishId = $publishId;
    }

    /**
     *  Método getRequest devuelve un array con los parametros del command
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31-08-2015
     * @return  Array
     */
    public function getRequest()
    {
        return [
            'type' => $this->type,
            'important' => $this->important,
            'publishId' => $this->publishId
        ];
    }
}