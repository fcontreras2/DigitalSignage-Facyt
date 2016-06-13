<?php

namespace DSFacyt\Core\Application\UseCases\Image\GetImage;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Image;
/**
 * Comando 'Obtener los datos de una imagen'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2016
 */

class GetImageCommand implements Command
{

    /**
    * Representa la imagen a editar
    * @var $iamgeId 
    **/
    private $imageId;

    /**
     *   Constructor de la clase
     *   @param integer $imageId
     */
    public function __construct($imageId)
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

}