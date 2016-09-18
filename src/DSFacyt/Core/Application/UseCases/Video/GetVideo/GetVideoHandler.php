<?php

namespace DSFacyt\Core\Application\UseCases\Video\GetVideo;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetVideo
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetVideoHandler implements Handler
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
     * Ejecuta el caso de uso 'Obtener los datos de la videon'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $request = $command->getRequest();
        $rpVideo = $rf->get('Video');
        $rpChannels = $rf->get('Channel');

        $video = $rpVideo->findOneBy(['id' => $request['video_id']]);

        if ($video) {
            $response = [];
            $response['id'] = $video->getId();
            $response['title'] = $video->getTitle();
            $response['description'] = $video->getDescription();
            $response['start_date'] = $video->getStartDate()->format('d/m/Y');
            $response['end_date'] = $video->getEndDate()->format('d/m/Y');
            $response['publish_time'] = $video->getPublishTime();
            $response['status'] = $video->getStatus();
            $response['important'] = $video->getImportant();
            $response['user_full_name'] = $video->getUser()->getName().' '.$video->getUser()->getLastName();

            $response['channels'] = [];
            $auxChannel = [];
            $allChannels = $rpChannels->findAll();
            foreach ($allChannels as $currentChannel) {
                $auxChannel['id'] = $currentChannel->getId();
                $auxChannel['name'] = $currentChannel->getName();
                $auxChannel['value'] = false;
                $response['channels'][] = $auxChannel;
            }

            $channels = $video->getChannels();
            
            foreach ($channels as $currentChannel) {
                $auxChannel['id'] = $currentChannel->getId();
                $auxChannel['name'] = $currentChannel->getName();
                $auxChannel['value'] = false;
                $key = array_search($auxChannel, $response['channels']);
                $response['channels'][$key]['value'] = true;
            }            

            $document = $video->getDocument();

            if ($document) {
                $response['video_url'] = $document->getFileName();
                $response['mime_type'] = mime_content_type($_SERVER['DOCUMENT_ROOT'].'/uploads/videos/'.$document->getFileName());                       
            }                
            
            return new ResponseCommandBus(200, 'Ok', $response);
        }

        return new ResponseCommandBus(404, 'Not found');
        
    }
}