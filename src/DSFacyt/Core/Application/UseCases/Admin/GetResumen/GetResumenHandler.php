<?php

namespace DSFacyt\Core\Application\UseCases\Admin\GetResumen;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso DeleteImage
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetResumenHandler implements Handler
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
        $this->command = $command;
        $this->rf = $rf;
        $data = $command->getRequest();

        $response = [];
        $response['publish'] = $this->getPublish($data['startDate'], $data['endDate']);
        //$response['channels'] = $this->getChannels($data['startDate'], $data['endDate']);

        return new ResponseCommandBus(200, 'Ok', $response);
    }

    /**
     * Consulta por tipo de publicaciones en un rango de fecha
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array
     */
    public function getPublish($startDate, $endDate)
    {
        $response = [
            'texts' => [0 => 0 ,1 => 0, 2 => 0, 3 => 0],
            'images' => [0 => 0 ,1 => 0, 2 => 0, 3 => 0],
            'videos' => [0 => 0 ,1 => 0, 2 => 0, 3 => 0],
        ];

        $rpText = $this->rf->get('Text');
        $rpImage = $this->rf->get('Image');
        $rpVideo = $this->rf->get('Video');


        $texts = $rpText->findByStartDateEndDate($startDate, $endDate);

        foreach ($texts as $currentText) {
            $index = $currentText->getStatus();
            $response['texts'][$index] ++;
        }

        $images = $rpImage->findByStartDateEndDate($startDate, $endDate);

        foreach ($images as $currentImage) {
            $index = $currentImage->getStatus();
            $response['images'][$index] ++;
        }

        $videos = $rpVideo->findByStartDateEndDate($startDate, $endDate);

        foreach ($videos as $currentVideo) {
            $index = $currentVideo->getStatus();
            $response['videos'][$index] ++;
        }

        //$response['images'] = $rpImage->findByStartDateEndDate($startDate, $endDate);
        //$response['video'] = $rpVideo->findByStartDateEndDate($startDate, $endDate);

        return $response;
    }

    /**
     * La siguiente función consulta los distintos tipos de publicaciones por canales
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array
     */
    public function getChannels($startDate, $endDate)
    {
        $response = [];
        $rpChannels = $this->rf->get('Channels');
        $rpText = $this->rf->get('Texts');
        $rpImages = $this->rf->get('Images');
        $rpVideos = $this->rf->get('Videos');
        $channels = $rpChannels->findAll();

        foreach ($channels as $currentChannel) {
            $auxChannel = [
                'name' => $currentChannel->getTitle(),
                'description' => $currentChannel->getTitle(),
                'status' => $currentChannel->getStatus(),
                'publish' => ['texts' => [], 'images' => [], 'videos' => []]
            ];
        }

        return $response;
    }
}