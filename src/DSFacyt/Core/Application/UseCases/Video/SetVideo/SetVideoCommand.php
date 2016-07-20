<?php

namespace DSFacyt\Core\Application\UseCases\Video\SetVideo;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Crear/Editar los datos de una video'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 30/09/2015
 */

class SetVideoCommand implements Command
{
    /**
    * @var File
    */
    private $video;

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
    public function __construct($video, $data, $user = null)
    {
        $this->video = $video;
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
            'video' => $this->video,
            'data' => $this->data,
            'user' => $this->user
        ];
    }
}