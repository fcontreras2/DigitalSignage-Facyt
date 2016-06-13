<?php

namespace DSFacyt\Core\Application\UseCases\Image\GetImage;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetImage
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetImageHandler implements Handler
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
     * Ejecuta el caso de uso 'Obtener los datos de la imagen'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $request = $command->getRequest();
        $rpImage = $rf->get('Image');
        $rpChannels = $rf->get('Channel');

        $image = $rpImage->findOneBy(['id' => $request['image_id']]);

        if ($image) {
            $response = [];
            $response['id'] = $image->getId();
            $response['title'] = $image->getTitle();
            $response['description'] = $image->getDescription();
            $response['start_date'] = $image->getStartDate()->format('d/m/Y');
            $response['end_date'] = $image->getEndDate()->format('d/m/Y');
            $response['publish_time'] = $image->getPublishTime();

            $response['channels'] = [];
            $auxChannel = [];
            $allChannels = $rpChannels->findAll();
            foreach ($allChannels as $currentChannel) {
                $auxChannel['id'] = $currentChannel->getId();
                $auxChannel['name'] = $currentChannel->getName();
                $auxChannel['value'] = false;
                $response['channels'][] = $auxChannel;
            }

            $channels = $image->getChannels();
            
            foreach ($channels as $currentChannel) {
                $auxChannel['id'] = $currentChannel->getId();
                $auxChannel['name'] = $currentChannel->getName();
                $auxChannel['value'] = false;
                $key = array_search($auxChannel, $response['channels']);
                $response['channels'][$key]['value'] = true;
            }            

            $document = $image->getDocument();

            $response['pathImage'] = $document ? $document->getFileName() : null;

            return new ResponseCommandBus(200, 'Ok', $response);
        }

        return new ResponseCommandBus(404, 'Not found');
        
    }
}