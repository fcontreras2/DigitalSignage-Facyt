<?php

namespace DSFacyt\Core\Application\UseCases\Video\EditVideo;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\Video;

/**
 * Clase para ejecutar el caso de uso EditVideo
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 01/09/2015
 */

class EditVideoHandler implements Handler
{
    /**
     * @var Representa el comando de la clase
     */
    private $command;

    /**
     * @var Representa la RepositorioFactory de la clase
     */
    private $rf;

    /**
     * Ejecuta el caso de uso 'Editar una Videon'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpVideo = $rf->get('Video');
        $video = $rpVideo->findOneBy(array('id' => $command->getVideoId()));

        if ($video) {
            $command->setEntityVideo($video);
            return new ResponseCommandBus(201, 'Ok');
        }

        return new ResponseCommandBus(404, 'No Found');
    }
}