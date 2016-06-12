<?php

namespace DSFacyt\Core\Application\UseCases\Image\SetImage;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Crear/Editar los datos de una imagen'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 30/09/2015
 */

class SetImageCommand implements Command
{

    /**
     * Representa la imagen (document/file)
     * @var Image $image
     */
    protected $image;

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
     *   Constructor de la clase
     *   @param integer $image
     */
    public function __construct($image  = null, $data, $user = null)
    {
        $this->image = $image;
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
            'image' => $this->image,
            'data' => $this->data,
            'user' => $this->user
        ];
    }
}