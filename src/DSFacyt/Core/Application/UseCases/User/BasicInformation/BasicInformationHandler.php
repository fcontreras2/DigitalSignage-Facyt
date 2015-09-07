<?php

namespace DSFacyt\Core\Application\UseCases\User\BasicInformation;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetTexts
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/09/2015
 */

class BasicInformationHandler implements Handler
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
     * Ejecuta el caso de uso 'Obtener todas los textos publicados por un usuario'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $response = array();
        $rpText = $rf->get('Text');
        $texts = $rpText->findAllByUser($command->getUser());
        $response['texts'] = count($texts);

        $rpImage = $rf->get('Image');
        $images =  $rpImage->findAllByUser($command->getUser());
        $response['images'] = count($images);


        $rpVideo = $rf->get('Video');
        $videos = $rpVideo->findAllByUser($command->getUser());
        $response['videos'] = count($videos);

        return new ResponseCommandBus(201, 'Ok', $response);
    }
}