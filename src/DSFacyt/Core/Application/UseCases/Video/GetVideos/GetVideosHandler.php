<?php

namespace DSFacyt\Core\Application\UseCases\Video\GetVideos;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Resources\Services\Pagination;

/**
 * Clase para ejecutar el caso de uso GetVideos
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 12/10/2015
 */

class GetVideosHandler implements Handler
{
    /**
     * @var Representa el comando de la clase
     */
    private $command;

    /**
     * @var La variable contiene el servicio de paginación
     */
    private $pagination;

    /**
     * @var Método set del servicio de paginación
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @var Método get del servicio de paginación
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @var Representa la RepositorioFactory de la clase
     */
    private $rf;

    /**
     * Ejecuta el caso de uso 'Obtener todas las videones publicadas por un usuario'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpVideo = $rf->get('Video');
        $videos = $rpVideo->findAllByUser($command->getUser());
        $response = array();

        if ($videos) {

            $responseVideo = array();
            $response['pagination'] = $this->pagination->generate($videos,$command->getPage());
            foreach ($videos as $currentVideo) {
                $auxVideo = array();
                $auxVideo['id'] = $currentVideo->getId();
                $auxVideo['start_date'] = $currentVideo->getStartDate()->format('d/m/Y');
                $auxVideo['end_date'] = $currentVideo->getEndDate()->format('d/m/Y');
                $auxVideo['publish_time'] = (new \DateTime($currentVideo->getPublishTime()))->format('h:i A');
                $auxVideo['title'] = $currentVideo->getTitle();
                $auxVideo['status'] = $currentVideo->getStatus();
                $auxVideo['url_video'] = $currentVideo->getDocument()->getFileName();
                $auxVideo['mime_type'] = mime_content_type($_SERVER['DOCUMENT_ROOT'].'/uploads/videos/'.$currentVideo->getDocument()->getFileName());
                $auxVideo['channels'] = array();

                foreach ($currentVideo->getChannels() as $currentChannel) {
                    $auxChannel = array();
                    $auxChannel['channel_id'] = $currentChannel->getId();
                    $auxChannel['channel_name'] = $currentChannel->getName();
                    array_push($auxVideo['channels'], $auxChannel);
                }
                array_push($responseVideo, $auxVideo);
            }

            $response['videos'] = $responseVideo;
        }

        return new ResponseCommandBus(201, 'Ok', $response);
    }
}   