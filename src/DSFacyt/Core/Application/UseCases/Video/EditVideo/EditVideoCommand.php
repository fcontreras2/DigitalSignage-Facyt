<?php

namespace DSFacyt\Core\Application\UseCases\Video\EditVideo;

use DSFacyt\Core\Application\Contract\Command;
/**
 * Comando 'Obtener los datos de una video'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2016
 */

class EditVideoCommand implements Command
{

    /**
    * Representa el video a editar
    * @var $iamgeId 
    **/
    private $videoId;

    private $entityVideo;

    /**
     *   Constructor de la clase
     *   @param integer $videoId
     */
    public function __construct($videoId = null)
    {
        $this->videoId = $videoId;        
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
            'video_id' => $this->videoId
        );
    }

    public function setVideoId($id)
    {
        $this->videoId = $id;
    }

    public function getVideoId(){ return $this->videoId;}

    public function setEntityVideo($entityVideo) { $this->entityVideo = $entityVideo;}

    public function getEntityVideo(){ return $this->entityVideo;}

}