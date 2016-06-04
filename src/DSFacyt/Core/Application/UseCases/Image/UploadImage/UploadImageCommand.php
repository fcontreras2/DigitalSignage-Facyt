<?php
namespace DSFacyt\Core\Application\UseCases\Image\UploadImage;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Image;

/**
 * Comando 'Subir una imagen al sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 12/10/2015
 */

class UploadImageCommand implements Command
{
    /**
     * La variable representa la entidad imagen
     * @var $image
     */
    protected $image;

    /**
    * La variable representa identificación del usuario en las carpeta de las imagenes    
	* @var $indentityFolderUser
    */
    protected $indentityFolderUser;

    /**
     *   Constructor de la clase
     *   @param Image $image
     */
    public function __construct(Image $image = null, $indentityFolderUser = null)
    {
        $this->image = $image;
        $this->indentityFolderUser = $indentityFolderUser;
    }

    /**
     * La función retorna todos los atributos de la clase en un arreglo
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>  
     * @return Array
     * @version 12/10/2015
     */
    public function getRequest()
    {
        return array(
            'image' => $this->image,
            'indentityFolderUser' => $this->indentityFolderUser
        );
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getIndentityFolderUser()
    {
        return $this->indentityFolderUser;
    }

    /**
     * @param string $image
     */
    public function setIndentityFolderUser($indentityFolderUser)
    {
        $this->indentityFolderUser = $indentityFolderUser;
    }
}