<?php

namespace DSFacyt\Core\Application\UseCases\Image\GetImages;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetImages
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 12/10/2015
 */

class GetImagesHandler implements Handler
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
     * Ejecuta el caso de uso 'Obtener todas las imagenes publicadas por un usuario'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpImage = $rf->get('Image');
        $images = $rpImage->findAllByUser($command->getUser());

        $response = array();

        foreach ($images as $currentImage) {
            $auxImage = array();
            $auxImage['text_id'] = $currentImage->getId();
            $auxImage['start_date'] = $currentImage->getStartDate()->format('d/m/Y');
            $auxImage['end_date'] = $currentImage->getEndDate()->format('d/m/Y');
            $auxImage['publish_time'] = $currentImage->getPublishTime()->format('h:i:s A');
            $auxImage['title'] = $currentImage->getTitle();
            $auxImage['status'] = $currentImage->getStatus();
            $auxImage['url_image'] = $currentImage->getDocument()->getFileName();
            $auxImage['channels'] = array();

            foreach ($currentImage->getChannels() as $currentChannel) {
                $auxChannel = array();
                $auxChannel['channel_id'] = $currentChannel->getId();
                $auxChannel['channel_name'] = $currentChannel->getName();
                array_push($auxImage['channels'], $auxChannel);
            }
            array_push($response, $auxImage);
        }

        return new ResponseCommandBus(201, 'Ok', $response);
    }
}   