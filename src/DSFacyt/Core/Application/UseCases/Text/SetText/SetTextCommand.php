<?php

namespace DSFacyt\Core\Application\UseCases\Text\SetText;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Crear/Editar los datos de una text'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 30/09/2015
 */

class SetTextCommand implements Command
{

    /**
    * Representa los datos de la publicación (título, fecha inicial, fecha final, etc)
    * @var array data
    **/
    protected $data;

    /**
    * Representa el usuario que publica'la información
    * @var string $user;
    **/
    protected $user;

    /**
    * Constructor de la clase
    **/
    public function __construct($data, $user = null)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * La función retorna todos los atributos de la clase en un arreglo
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @return Array
     * @version 30/09/2015
     */
    public function getRequest()
    {
        return [
            'data' => $this->data,
            'user' => $this->user
        ];
    }
}