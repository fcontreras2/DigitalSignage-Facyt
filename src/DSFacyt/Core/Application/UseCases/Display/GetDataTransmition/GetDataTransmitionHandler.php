<?php

namespace DSFacyt\Core\Application\UseCases\Display\GetDataTransmition;

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

class GetDataTransmitionHandler implements Handler
{
    private $rf;

    /**
    * @var integer id del canal a buscar
    */
    private $channelId;

    /**
     * Ejecuta el caso de uso 'Obtener la información a transmitir'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $this->rf = $rf;
        $response = ['publish' => [], 'quick_notes' => []];

        $slug = $command->getRequest()['slug'];
        $channel = $rf->get('Channel')->findOneBy(['slug' => $slug]);

        if ($channel) {
            $this->channelId = $channel->getId();
            $response['publish']['texts'] = $this->getTexts();
            $response['publish']['images'] = $this->getImages();
        
            $response['quickNotes'] = $this->getQuickNotes();

            return new ResponseCommandBus(200, 'Ok', $response);
        }

        return new ResponseCommandBus(404,'Not Found');
    }

    private function getTexts()
    {
        $response = [];
        $rpText = $this->rf->get('Text');

        $texts = $rpText->findActiveByChannel($this->channelId);
        $auxResponse = [];

        foreach ($texts as $currentText) {
            
            $auxResponse['id'] = $currentText->getId();
            $auxResponse['info'] = $currentText->getInfo();
            $auxResponse['title'] = $currentText->getTitle();
            $auxResponse['start_date'] = $currentText->getStartDate()->format('d-m-Y');
            $auxResponse['user_full_name'] = $currentText->getUser()->getName().' '.$currentText->getUser()->getLastName();

            $response[] = $auxResponse;
        }

        return $response;
    }

    private function getImages()
    {
        $response = [];
        $rpImage = $this->rf->get('Image');

        $images = $rpImage->findActiveByChannel($this->channelId);
        $auxResponse = [];

        foreach ($images as $currentImage) {
            
            $auxResponse['id'] = $currentImage->getId();
            $auxResponse['image_url'] = $currentImage->getDocument()->getFileName();
            $auxResponse['title'] = $currentImage->getTitle();
            $auxResponse['start_date'] = $currentImage->getStartDate();
            $auxResponse['user_full_name'] = $currentImage->getUser()->getFullName();

            $response[] = $auxResponse;
        }

        return $response;
    }

    private function getQuickNotes()
    {
        $response = [];
        $rpQuickNote = $this->rf->get('QuickNote');

        $quickNotes = $rpQuickNote->findBy(['status' => 0]);
        $auxResponse = [];
        foreach ($quickNotes as $currentQuickNote) {
            
            $auxResponse['id'] = $currentQuickNote->getId();
            $auxResponse['info'] = $currentQuickNote->getId();
            $response[] = $auxResponse;
        }

        return $response;
    }
}