<?php

namespace DSFacyt\Core\Application\UseCases\Video\DeleteVideo;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\Notification;
/**
 * Clase para ejecutar el caso de uso DeleteVideo
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class DeleteVideoHandler implements Handler
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
     * Ejecuta el caso de uso 'Eliminar la videon'
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

            $video->setActive(false);
            $rpVideo->save($video);
            $notification = new Notification();
            $notification->setPublishId($video->getId());
            $notification->setPublishType('video');
            $notification->setEvent('finished');
            $rf->get('Notification')->save($notification);
            /*try {
                $video->getDocument()->removeFile('video');   
                $rpVideo->delete($video);
                return new ResponseCommandBus(201, 'Ok');
            } catch (\Exception $e) {
                return new ResponseCommandBus(500,$e->getmessage(),'No se pudo eliminar');
            }*/
            return new ResponseCommandBus(200,'Ok');
        }

        return new ResponseCommandBus(404, 'No Found');
    }
}