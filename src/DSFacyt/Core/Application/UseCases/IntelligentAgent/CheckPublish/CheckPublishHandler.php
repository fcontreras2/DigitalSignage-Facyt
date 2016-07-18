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

        // Conseguimos publicaciones (nuevas, )
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
            
            $lastStatus = $currentText->getStatus();
            $currentNotification->setEvent($this->getEvent($currentText->getStatus()));
            $currentNotification->setLastModified(new \DateTime());
            $currentText->setStatus($this->changeStatus($currentText->getStatus()));
            $currentNotification->setData($this->getData($currentText->getStatus(), $lastStatus));

            $rpNotification->save($currentNotification);            
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

            $lastStatus = $currentImage->getStatus();
            $currentNotification->setLastModified(new \DateTime());
            $currentNotification->setEvent($this->getEvent($currentImage->getStatus()));
            $currentImage->setStatus($this->changeStatus($currentImage->getStatus()));
            $currentNotification->setData($this->getData($currentImage->getStatus(),$lastStatus));

            $rpNotification->save($currentNotification);
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

            $lastStatus = $currentVideo->getStatus();
            $currentNotification->setLastModified(new \DateTime());
            $currentNotification->setEvent($this->getEvent($currentVideo->getStatus()));
            $currentVideo->setStatus($this->changeStatus($currentVideo->getStatus()));            
            $currentNotification->setData($this->getData($currentVideo->getStatus(),$lastStatus));

            $rpNotification->save($currentNotification);
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

    private function changeStatus($status)
    {
        $response = $status;

        if ($status == 1 or $status == 2) {
            $response = $status + 1;
        }

        return $response;
    }

    private function getData($status, $lastStatus)
    {
        $response = ['last_status' => $lastStatus, 'info' => null];
        switch ($status) {
            case 0:
                $response['info'] = 'Publicación creada';
                break;
            case 2:
                $response['info'] = 'Publicación en transmisión (activa)';
                break;
            case 3:
                $response['info'] = 'Publicación finalizada';
                break;
        }

        return $response;
    }
}