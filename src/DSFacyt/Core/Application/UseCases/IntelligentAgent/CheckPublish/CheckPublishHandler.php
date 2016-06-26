<?php

namespace DSFacyt\Core\Application\UseCases\IntelligentAgent\CheckPublish;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\Notification;

/**
 * Handler del 'El caso de uso de se encarga de analizar y cambiar los estados de las publicaciones'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class CheckPublishHandler implements Handler
{
    /**
     * Ejecuta el caso de uso 'El caso de uso de se encarga de analizar y cambiar los estados de las publicaciones'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */   public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpText = $rf->get('Text');
        $rpNotification = $rf->get('Notification');

        $texts = $rpText->findAllToCheck();

        foreach ($texts as $currentText) {

            $currentNotification = $rpNotification->findOneBy([
                'publish_id' => $currentText->getId(),
                'publish_type' => 'text'
            ]);

            if (!$currentNotification) {
                $currentNotification = new Notification();
                $currentNotification->setPublishId($currentText->getId());
                $currentNotification->setPublishType('text');
            }

            $currentNotification->setData([]);
            $currentNotification->setLastModified(new \DateTime());
            $currentNotification->setEvent($this->getEvent($currentText->getStatus()));
            $rpNotification->save($currentNotification);
            

            $currentText->setStatus($currentText->getStatus()+1);
            $rpText->save($currentText);            
        }        

        $rpImage = $rf->get('Image');

        $images = $rpImage->findAllToCheck();

         foreach ($images as $currentImage) {

            $currentNotification = $rpNotification->findOneBy([
                'publish_id' => $currentImage->getId(),
                'publish_type' => 'image'
            ]);

            if (!$currentNotification) {
                $currentNotification = new Notification();
                $currentNotification->setPublishId($currentImage->getId());
                $currentNotification->setPublishType('text');
            }

            $currentNotification->setData([]);
            $currentNotification->setLastModified(new \DateTime());
            $currentNotification->setEvent($this->getEvent($currentImage->getStatus()));
            $rpNotification->save($currentNotification);
            

            $currentImage->setStatus($currentImage->getStatus()+1);
            $rpImage->save($currentImage);            
        }

        $rpVideo = $rf->get('Video');

        $videos = $rpVideo->findAllToCheck();

         foreach ($videos as $currentVideo) {

            $currentNotification = $rpNotification->findOneBy([
                'publish_id' => $currentVideo->getId(),
                'publish_type' => 'video'
            ]);

            if (!$currentNotification) {
                $currentNotification = new Notification();
                $currentNotification->setPublishId($currentVideo->getId());
                $currentNotification->setPublishType('text');
            }

            $currentNotification->setData([]);
            $currentNotification->setLastModified(new \DateTime());
            $currentNotification->setEvent($this->getEvent($currentVideo->getStatus()));
            $rpNotification->save($currentNotification);            

            $currentVideo->setStatus($currentVideo->getStatus()+1);
            $rpImage->save($currentVideo);            
        }
        
        return new ResponseCommandBus(200,'Ok');
    }

    private function getEvent($status)
    {
        switch ($status) {
            case 0:
                $response = 'new';
                break;
            case 1:
                $response = 'active';
                break;
            case 2:
                $response = 'finished';
                break;
        }

        return $response;
    }
}