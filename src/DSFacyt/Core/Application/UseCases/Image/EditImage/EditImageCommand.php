<?php

namespace DSFacyt\Core\Application\UseCases\Image\EditImage;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Image;
/**
 * Comando 'Editar los datos de una imagen'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 30/09/2015
 */

class EditImageCommand implements Command
{
    /**
     * La variable representa el id de la imagen a editar
     * @var integer $imageId
     */
    protected $imageId;

    /**
     * El atributo de la clase representa la imagen el cual se va editar
     * @var Image $entityImage
     */
    protected $entityImage;

    /**
     *   Constructor de la clase
     *   @param integer $image
     */
    public function __construct($imageId = null, $entityImage  = null)
    {
        $this->imageId = $imageId;
        $this->entityImage = $entityImage;
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
            'image_id' => $this->imageId,
            'entityImage' => $this->entityImage
        );
    }

    /**
     * @return int
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @param int $imageId
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;
    }

    /**
     * @return Image
     */
    public function getEntityImage()
    {
        return $this->entityImage;
    }

    /**
     * @param Text $entityImage
     */
    public function setEntityImage($entityImage)
    {
        $this->entityImage = $entityImage;
    }
}