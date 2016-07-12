<?php

namespace DSFacyt\Core\Application\UseCases\GetImportantAll;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Comando 'Obtiene todas las publicaciones importantes'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class GetImportantAllHandler implements Handler
{
    private $rf;

    /**
     * Ejecuta el caso de uso 'Obtiene todas las publicaciones importantes'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $response = ['texts' => [], 'images' => [], 'videos' => []];
        $rpText = $rf->get('Text');
        $rpImages = $rf->get('Image');
        $rpVideos = $rf->get('Video');

        $texts = $rpText->findLastImportant();

        foreach ($texts as $currentText) {
            $auxText = [];
            $auxText['id'] = $currentText->getId();
            $auxText['title'] = $currentText->getTitle();
            $auxText['info'] = $currentText->getInfo();
            $auxText['start_date'] = $currentText->getStartDate()->format('d-m-Y');
            $auxText['user_full_name'] = $currentText->getUser()->getName().' '.$currentText->getUser()->getLastName();
            $response['texts'][] = $auxText;
        }

        $images = $rpImages->findLastImportant();

        foreach ($images as $currentImage) {
            $auxImage = [];
            $auxImage['id'] = $currentImage->getId();
            $auxImage['title'] = $currentImage->getTitle();
            $auxImage['image_url'] = $currentImage->getDocument()->getFileName();
            $auxImage['start_date'] = $currentImage->getStartDate()->format('d-m-Y');
            $auxImage['user_full_name'] = $currentImage->getUser()->getName().' '.$currentImage->getUser()->getLastName();
            $response['images'][] = $auxImage;
        }

        $videos = $rpVideos->findLastImportant();
        foreach ($videos as $currentVideo) {
            $auxImage = [];
            $auxImage['id'] = $currentVideo->getId();
            $auxImage['title'] = $currentVideo->getTitle();
            $auxImage['start_date'] = $currentVideo->getStartDate()->format('d-m-Y');
            $auxImage['user_full_name'] = $currentVideo->getUser()->getName().' '.$currentImage->getUser()->getLastName();
            $response['videos'][] = $auxImage;
        }



        return new ResponseCommandBus(200, 'Ok', $response);
    }
}