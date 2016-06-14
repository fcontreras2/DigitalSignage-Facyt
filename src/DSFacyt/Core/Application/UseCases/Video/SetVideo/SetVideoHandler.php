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
        } else
            $video = new Video();
        
        $video->updateObject($request['data']);
        $video->setUser($request['user']);
        
        $video->setStatus(0);
        
            foreach ($request['data']['channels'] as $currentChannel) {

                $channel = $rpChannel->findOneBy(['id' => $currentChannel['id']]);
                $video->removeChannel($channel);
                if ($channel) {
                    if (isset($currentChannel['value']) and $currentChannel['value'])
                        $video->addChannel($channel);
                    else
                        $video->removeChannel($channel);
                }
            }
            
            $rpVideo->save($video);


        return new ResponseCommandBus(201,'Created');
        
    }
}