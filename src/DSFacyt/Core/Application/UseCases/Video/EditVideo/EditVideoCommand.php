<?php

namespace DSFacyt\Core\Application\UseCases\Video\EditVideo;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Video;
/**
 * Comando 'Editar los datos de una videon'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 30/09/2015
 */

class EditVideoCommand implements Command
{
    /**
     * La variable representa el id de la videon a editar
     * @var integer $videoId
     */
    protected $videoId;

    /**
     * El atributo de la clase representa la videon el cual se va editar
     * @var Video $entityVideo
     */
    protected $entityVideo;

    /**
     *   Constructor de la clase
     *   @param integer $video
     */
    public function __construct($videoId = null, $entityVideo  = null)
    {
        $this->videoId = $videoId;
        $this->entityVideo = $entityVideo;
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
            'video_id' => $this->videoId,
            'entityVideo' => $this->entityVideo
        );
    }

    /**
     * @return int
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * @param int $videoId
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }

    /**
     * @return Video
     */
    public function getEntityVideo()
    {
        return $this->entityVideo;
    }

    /**
     * @param Video $entityVideo
     */
    public function setEntityVideo($entityVideo)
    {
        $this->entityVideo = $entityVideo;
    }
}