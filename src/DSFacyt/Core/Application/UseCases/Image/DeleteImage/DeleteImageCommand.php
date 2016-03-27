<?php

namespace DSFacyt\Core\Application\UseCases\Image\DeleteImage;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Image;
/**
 * Comando 'Eliminar los datos de una imagen'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2016
 */

class DeleteImageCommand implements Command
{
    /**
     * La variable representa el id de la image a editar
     * @var integer $imageId
     */
    protected $imageId;

    /**
     *   Constructor de la clase
     *   @param integer $imageId
     */
    public function __construct($imageId = null)
    {
        $this->imageId = $imageId;        
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
        return array(
            'image_id' => $this->imageId
        );
    }

    /**
     * Método Get del atributo $imageId
     * @return integer
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Método Set del atributo $imageId
     * @param integer $imageId
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;
    }    
}