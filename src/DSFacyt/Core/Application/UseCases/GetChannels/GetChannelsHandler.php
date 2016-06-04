<?php

namespace DSFacyt\Core\Application\UseCases\GetChannels;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso "Obtiene la información de todos los canales"
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetChannelsHandler implements Handler
{
    /**
     * Ejecuta el caso de uso 'Obtiene la información de todos los canales'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $response = [];
        $rpChannel = $rf->get('Channel');

        $channels = $rpChannel->findAll();
        $auxChannel = [];
        foreach ($channels as $currentChannel) {
            $auxChannel['slug'] = $currentChannel->getSlug();
            $auxChannel['description'] = $currentChannel->getDescription();

            $auxChannel['name'] = $currentChannel->getName();
            $response[] = $auxChannel;
        }

        return new ResponseCommandBus(200, 'Ok', $response);
    }
}