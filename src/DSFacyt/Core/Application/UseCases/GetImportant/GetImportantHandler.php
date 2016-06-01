<?php

namespace DSFacyt\Core\Application\UseCases\GetImportant;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Comando 'Obtiene las publicaciones importante de la semana'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class GetImportantHandler implements Handler
{
    private $rf;

    /**
     * Ejecuta el caso de uso 'Obtiene las publicaciones importante de la semana'
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