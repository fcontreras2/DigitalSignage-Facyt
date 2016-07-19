<?php

namespace DSFacyt\Core\Application\UseCases\Video\GetVideo;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Video;
/**
 * Comando 'Obtener los datos de una videon'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2016
 */

class GetVideoCommand implements Command
{

    /**
    * Representa la videon a editar
    * @var $iamgeId 
    **/
    private $videoId;

    /**
     *   Constructor de la clase
     *   @param integer $videoId
     */
    public function __construct($videoId)
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

}