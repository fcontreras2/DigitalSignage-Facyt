<?php

namespace DSFacyt\Core\Application\UseCases\Text\GetTexts;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetTexts
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 01/09/2015
 */

class GetTextsHandler implements Handler
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
        $rpText = $rf->get('Text');
        $texts = $rpText->findAllByUser($command->getUser());

        $response = array();

        foreach ($texts as $currentTexts) {
            $auxText = array();
            $auxText['text_id'] = $currentTexts->getId();
            $auxText['start_date'] = $currentTexts->getStartDate();
            $auxText['end_date'] = $currentTexts->getEndDate();
            $auxText['publish_time'] = $currentTexts->getPublishTime();
            $auxText['title'] = $currentTexts->getTitle();
            $auxText['info'] = $currentTexts->getInfo();
            $auxText['status'] = $currentTexts->getStatus();
            $auxText['channels'] = array();

            foreach ($currentTexts->getChannels() as $currentChannel) {
                $auxChannel = array();
                $auxChannel['channel_id'] = $currentChannel->getId();
                $auxChannel['channel_name'] = $currentChannel->getName();
                array_push($auxText['channels'], $auxChannel);
            }
            array_push($response, $auxText);
        }

        return new ResponseCommandBus(201, 'Ok', $response);
    }
}   