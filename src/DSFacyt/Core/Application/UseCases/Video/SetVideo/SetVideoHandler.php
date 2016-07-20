<?php

namespace DSFacyt\Core\Application\UseCases\Video\SetVideo;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\Video;
use DSFacyt\InfrastructureBundle\Entity\Document;

/**
 * Clase para ejecutar el caso de uso SetVideo
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 01/09/2015
 */

class SetVideoHandler implements Handler
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
     * Ejecuta el caso de uso 'Crear/Editar una Videon'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $request = $command->getRequest();
        $video = null;
        $oldVideo = null;
        $rpVideo = $rf->get('Video');
        $rpChannel = $rf->get('Channel');

        if (isset($request['data']['id'])) {
            $video = $rpVideo->findOneBy(['id' => $request['data']['id']]);
            if (!$video)
                return new ResponseCommandBus(404, 'Not Found');
        } else {
            $video = new Video();
            $video->setUser($request['user']));
        }
        
        $video->updateObject($request['data']);

        if (!isset($request['data']['status']))
            $video->setStatus(0);
        else
            $video->setStatus($request['data']['status']);            


        if ($request['video']) {
            $document = $video->getDocument();
            if ($document) 
                $oldImage = $video->getDocument()->getFileName();
            else {
                $image->setDocument(new Document());
                $document = $video->getDocument();
            }

            $video->getDocument()->setName($image->getTitle());
            $document->setFile($request['video']);
            $fileName = strtolower(str_replace(' ','_',$image->getTitle())).'_';
            $video->getDocument()->upload('video', $video->getUser()->getIndentityCard().'/',$fileName);
        }

        $video->removeAllChannels($channel);
    
        foreach ($request['data']['channels'] as $currentChannel) {

            $channel = $rpChannel->findOneBy(['id' => $currentChannel['id']]);
            
            if ($channel) {                
                $video->addChannel($channel);
        }
        
        $rpVideo->save($video);

        return new ResponseCommandBus(201,'Created');
        
    }
}