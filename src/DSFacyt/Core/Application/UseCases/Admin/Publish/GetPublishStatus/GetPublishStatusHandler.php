<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Publish\GetPublishStatus;

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

class GetPublishStatusHandler implements Handler
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
     * Ejecuta el caso de uso 'Eliminar la imagen'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $data = $command->getRequest();
        $rpFactory = $rf->get($data['type']);
        $response = [];

        $publish = $rpFactory->findByData($data);

        if ($publish) {
            $response['pagination'] = $this->pagination->generate($publish, $data['page']);

            foreach ($publish as $currentPublish) {
                $auxPublish = [];
                $auxPublish['id'] = $currentPublish->getId();
                $auxPublish['start_date'] = $currentPublish->getStartDate()->format('d-m-Y');
                $auxPublish['end_date'] = $currentPublish->getEndDate()->format('d-m-Y');
                $auxPublish['title'] = $currentPublish->getTitle();
                $auxPublish['publish_time'] = $currentPublish->getPublishTime();
                $auxPublish['user_name'] = $currentPublish->getUser()->getUserName();
                $auxPublish['channels'] = [];
                $auxPublish['status'] = $currentPublish->getStatus();
                $auxPublish['important'] = $currentPublish->getImportant();

                if ($data['type'] == 'Text')
                    $auxPublish['info'] = $currentPublish->getInfo();
                else if ($data['type'] == 'Image')
                    $auxPublish['url_image'] = $currentPublish->getDocument()->getFileName();

                foreach ($currentPublish->getChannels() as $currentChannel) {
                    $auxChannel = [];
                    $auxChannel['channel_id'] = $currentChannel->getId();
                    $auxChannel['channel_name'] = $currentChannel->getName();
                    $auxPublish['channels'][] = $auxChannel;
                }

                $response['publish'][] = $auxPublish;

            }                        
        }

        return new ResponseCommandBus(200, 'Ok', $response);
    }
}