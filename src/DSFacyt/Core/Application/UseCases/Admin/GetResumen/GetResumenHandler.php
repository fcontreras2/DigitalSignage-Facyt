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
     * @var array  Array con los distintos tipos de estados
     * (Pendiente (0), Corregir Publicación (1), Aceptada (2), Cancelada (3), Finalizada (4)
     */
    private $initialArray = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        for ($i = 0; $i < 5 ;$i++)
            $this->initialArray[$i] = 0;
    }
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
            'texts' => $this->initialArray,
            'images' => $this->initialArray,
            'videos' => $this->initialArray
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