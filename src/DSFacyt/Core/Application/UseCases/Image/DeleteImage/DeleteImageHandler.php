<?php

namespace DSFacyt\Core\Application\UseCases\Image\DeleteImage;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\Notification;
/**
 * Clase para ejecutar el caso de uso DeleteImage
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class DeleteImageHandler implements Handler
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
     * Ejecuta el caso de uso 'Eliminar la imagen'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpImage = $rf->get('Image');
        $image = $rpImage->findOneBy(array('id' => $command->getImageId()));

        if ($image) {

            $image->setActive(false);
            $image->setStatus(3);
            $rpImage->save($image);
            $notification = new Notification();
            $notification->setPublishId($image->getId());
            $notification->setPublishType('image');
            $notification->setEvent('finished');
            $rf->get('Notification')->save($notification);
            /*try {
                $image->getDocument()->removeFile('image');   
                $rpImage->delete($image);
                return new ResponseCommandBus(201, 'Ok');
            } catch (\Exception $e) {
                return new ResponseCommandBus(500,$e->getmessage(),'No se pudo eliminar');
            }*/
            return new ResponseCommandBus(200,'Ok');
        }

        return new ResponseCommandBus(404, 'No Found');
    }
}