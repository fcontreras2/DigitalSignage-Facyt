<?php

namespace DSFacyt\Core\Application\UseCases\Video\UploadVideo;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetVideos
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 12/10/2015
 */

class UploadVideoHandler implements Handler
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
     * Ejecuta el caso de uso 'Publicar una videon en el sistema'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpVideo = $rf->get('Video');
        $video = $command->getVideo();
        try {
            $video->getDocument()->setName($video->getTitle());
            $video->setStatus(0);
            $fileName = strtolower(str_replace(' ','_',$video->getTitle())).'_';
            die();
            $video->getDocument()->upload('video', $command->getIndentityFolderUser().'/',$fileName);
            $rpVideo->save($video);

        } catch(\Exception $e) {
            return new ResponseCommandBus(500, 'Error Server', $e->getMessage());
        }

        return new ResponseCommandBus(201, 'Ok');
    }
}   