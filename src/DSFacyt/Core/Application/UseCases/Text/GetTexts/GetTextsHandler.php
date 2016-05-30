<?php

namespace DSFacyt\Core\Application\UseCases\Text\GetTexts;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Resources\Services\Pagination;
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

        //todos los textos encontrados del usuario
        $texts = $rpText->findAllByUser($command->getUser());
        //array de respuesta
        $response = array();

        if ($texts) {

            $responseText = array();
            $response['pagination'] = $this->pagination->generate($texts,$command->getPage());

            foreach ($texts as $currentTexts) {
                $auxText = array();
                $auxText['id'] = $currentTexts->getId();
                $auxText['start_date'] = $currentTexts->getStartDate()->format('d/m/Y');
                $auxText['end_date'] = $currentTexts->getEndDate()->format('d/m/Y');
                $auxTime = (new \DateTime($currentTexts->getPublishTime()))->format('h:i A');

                $auxText['publish_time'] = $auxTime;
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
                array_push($responseText, $auxText);
            }
             $response['texts'] = $responseText;
        }

        return new ResponseCommandBus(201, 'Ok', $response);
    }
}   