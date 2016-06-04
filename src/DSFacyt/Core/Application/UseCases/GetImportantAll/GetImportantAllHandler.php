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
        $response = ['texts' => [], 'images' => []];
        $rpText = $rf->get('Text');
        $rpImages = $rf->get('Image');

        $texts = $rpText->findLastImportant();

        foreach ($texts as $currentText) {
            $auxText = [];
            $auxText['id'] = $currentText->getId();
            $auxText['title'] = $currentText->getTitle();
            $auxText['info'] = $currentText->getInfo();
            $auxText['start_date'] = $currentText->getStartDate()->format('Y-m-d');
            $auxText['user_full_name'] = $currentText->getUser()->getName().' '.$currentText->getUser()->getLastName();
            $response['texts'][] = $auxText;
        }

        $images = $rpImages->findLastImportant();

        foreach ($images as $currentImage) {
            $auxImage = [];
            $auxImage['id'] = $currentImage->getId();
            $auxImage['title'] = $currentImage->getTitle();
            $auxImage['image_url'] = $currentImage->getDocument()->getFileName();
            $response['images'][] = $auxImage;
        }

        return new ResponseCommandBus(200, 'Ok', $response);
    }
}