<?php

namespace DSFacyt\Core\Application\UseCases\Text\SetText;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\Text;
use DSFacyt\InfrastructureBundle\Entity\Document;

/**
 * Clase para ejecutar el caso de uso SetText
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 01/09/2015
 */

class SetTextHandler implements Handler
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
     * Ejecuta el caso de uso 'Crear/Editar una Textn'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $request = $command->getRequest();
        $text = null;
        $oldText = null;
        $rpText = $rf->get('Text');
        $rpChannel = $rf->get('Channel');
        
        if (isset($request['data']['id'])) {
            $text = $rpText->findOneBy(['id' => $request['data']['id']]);
            if (!$text)
                return new ResponseCommandBus(404, 'Not Found');
        } else
            $text = new Text();
        
        $text->updateObject($request['data']);
        $text->setUser($request['user']);
        
        if (!isset($request['data']['status'])) 
            $text->setStatus(0);        
        
            foreach ($request['data']['channels'] as $currentChannel) {

                $channel = $rpChannel->findOneBy(['id' => $currentChannel['id']]);
                $text->removeChannel($channel);
                if ($channel) {
                    if (isset($currentChannel['value']) and $currentChannel['value'])
                        $text->addChannel($channel);
                    else
                        $text->removeChannel($channel);
                }
            }
            
            $rpText->save($text);


        return new ResponseCommandBus(201,'Created');
        
    }
}