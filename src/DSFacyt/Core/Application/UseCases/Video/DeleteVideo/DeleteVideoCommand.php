<?php

namespace DSFacyt\Core\Application\UseCases\Video\DeleteVideo;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Video;
/**
 * Comando 'Eliminar los datos de una videon'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2016
 */

class DeleteVideoCommand implements Command
{
    /**
     * La variable representa el id de la video a editar
     * @var integer $videoId
     */
    protected $videoId;

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

    /**
     * Método Get del atributo $videoId
     * @return integer
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Método Set del atributo $videoId
     * @param integer $videoId
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }    
}