<?php
namespace DSFacyt\Core\Application\UseCases\Video\UploadVideo;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Video;

/**
 * Comando 'Subir una videon al sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 12/10/2015
 */

class UploadVideoCommand implements Command
{
    /**
     * La variable representa la entidad videon
     * @var $video
     */
    protected $video;

    /**
    * La variable representa identificación del usuario en las carpeta de las videones    
	* @var $indentityFolderUser
    */
    protected $indentityFolderUser;

    /**
     *   Constructor de la clase
     *   @param Video $video
     */
    public function __construct(Video $video = null, $indentityFolderUser = null)
    {
        $this->video = $video;
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
            'video' => $this->video,
            'indentityFolderUser' => $this->indentityFolderUser
        );
    }

    /**
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Video $video
     */
    public function setVideo(Video $video)
    {
        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getIndentityFolderUser()
    {
        return $this->indentityFolderUser;
    }

    /**
     * @param string $video
     */
    public function setIndentityFolderUser($indentityFolderUser)
    {
        $this->indentityFolderUser = $indentityFolderUser;
    }
}