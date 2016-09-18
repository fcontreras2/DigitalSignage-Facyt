<?php

namespace DSFacyt\Core\Application\UseCases\Text\GetText;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetText
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetTextHandler implements Handler
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
     * Ejecuta el caso de uso 'Obtener los datos de la texto'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $request = $command->getRequest();
        $rpText = $rf->get('Text');
        $rpChannels = $rf->get('Channel');

        $text = $rpText->findOneBy(['id' => $request['text_id']]);

        if ($text) {
            $response = [];
            $response['id'] = $text->getId();
            $response['title'] = $text->getTitle();
            $response['info'] = $text->getInfo();
            $response['start_date'] = $text->getStartDate()->format('d/m/Y');
            $response['end_date'] = $text->getEndDate()->format('d/m/Y');
            $response['status'] = $text->getStatus();
            $response['important'] = $text->getImportant();
            $response['publish_time'] = $text->getPublishTime();
            $response['user_full_name'] = $text->getUser()->getName().' '.$text->getUser()->getLastName();

            $response['channels'] = [];
            $auxChannel = [];
            $allChannels = $rpChannels->findAll();
            foreach ($allChannels as $currentChannel) {
                $auxChannel['id'] = $currentChannel->getId();
                $auxChannel['name'] = $currentChannel->getName();
                $auxChannel['value'] = false;
                $response['channels'][] = $auxChannel;
            }

            $channels = $text->getChannels();
            
            foreach ($channels as $currentChannel) {
                $auxChannel['id'] = $currentChannel->getId();
                $auxChannel['name'] = $currentChannel->getName();
                $auxChannel['value'] = false;
                $key = array_search($auxChannel, $response['channels']);
                $response['channels'][$key]['value'] = true;
            }            


            return new ResponseCommandBus(200, 'Ok', $response);
        }

        return new ResponseCommandBus(404, 'Not found');
        
    }
}