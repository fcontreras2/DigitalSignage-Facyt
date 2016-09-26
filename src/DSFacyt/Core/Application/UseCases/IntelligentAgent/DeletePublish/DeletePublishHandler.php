<?php

namespace DSFacyt\Core\Application\UseCases\IntelligentAgent\DeletePublish;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Handler del 'El handler de eliminación de publicaciones viejas del sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class DeletePublishHandler implements Handler
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
        $rpImage = $rf->get('Image');
        $rpVideo = $rf->get('Video');
        $rpNotification = $rf->get('Notification');
        $maxDate = $command->getRequest()['maxDate'];
        $response = [];

        try {
            $texts = $rpText->findOldByDays($maxDate);

            foreach ($texts as $currentText) {
                $rpText->delete($currentText);
                $notification = $rpNotification->findOneBy([
                    'publish_id' => $currentText->getId(), 
                    'publish_type' => 'text'
                ]);

                if ($notification)
                    $rpNotification->delete($notification);
            }            

            $images = $rpImage->findOldByDays($maxDate);

            foreach ($images as $currentImage) {
                $pathFile = $currentImage->getDocument()->getFileName();
                $rpImage->delete($currentImage);
                unlink('web/uploads/images/'.$pathFile);
                $notification = $rpNotification->findOneBy([
                    'publish_id' => $currentImage->getId(),
                    'publish_type' => 'image'
                ]);
                if ($notification)
                    $rpNotification->delete($notification);
            }

            $videos = $rpVideo->findOldByDays($maxDate);

            foreach ($videos as $currentVideo) {
                $pathFile = $currentVideo->getDocument()->getFileName();
                $rpVideo->delete($currentVideo);
                unlink('web/uploads/videos/'.$pathFile);
                $notification = $rpNotification->findOneBy([
                    'publish_id' => $currentVideo->getId(),
                    'publish_type' => 'video'
                ]);
                if ($notification)
                    $rpNotification->delete($notification);
            }    

            return new ResponseCommandBus(200, 'Ok');
        } catch (\Ȩxception $e) {
            return new ResponseCommandBus(500, 'Error', $e->getMessage());
        }        
    }
}