<?php

namespace DSFacyt\Core\Application\UseCases\Image\SetImage;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use DSFacyt\InfrastructureBundle\Entity\Image;
use DSFacyt\InfrastructureBundle\Entity\Document;

/**
 * Clase para ejecutar el caso de uso SetImage
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 01/09/2015
 */

class SetImageHandler implements Handler
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
     * Ejecuta el caso de uso 'Crear/Editar una Imagen'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $request = $command->getRequest();
        $image = null;
        $oldImage = null;
        $rpImage = $rf->get('Image');
        $rpChannel = $rf->get('Channel');

        if (isset($request['data']['id'])) {
            $image = $rpImage->findOneBy(['id' => $request['data']['id']]);
            if (!$image)
                return new ResponseCommandBus(404, 'Not Found');
        } else
            $image = new Image();
        
        $image->updateObject($request['data']);
        
        if ($request['image']) {
            $document = $image->getDocument();
            if ($document) 
                $oldImage = $image->getDocument()->getFileName();
            else {
                $image->setDocument(new Document());
                $document = $image->getDocument();
            }

            $image->getDocument()->setName($image->getTitle());
            $image->setStatus(0);
            $document->setFile($request['image']);
            $fileName = strtolower(str_replace(' ','_',$image->getTitle())).'_';
            $image->getDocument()->upload('image', $request['user']->getIndentityCard().'/',$fileName);
            $image->setUser($request['user']);

            foreach ($request['data']['channels'] as $currentChannel) {

                $channel = $rpChannel->findOneBy(['id' => $currentChannel['id']]);
                $image->removeChannel($channel);
                if ($channel) {
                    if (isset($currentChannel['value']) and $currentChannel['value'])
                        $image->addChannel($channel);
                    else
                        $image->removeChannel($channel);
                }
            }
            
            $rpImage->save($image);
            if ($oldImage)
                unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/images/'.$oldImage);

            return new ResponseCommandBus(201,'Created');
        }

        return new ResponseCommandBus(404, 'Bad Request');
    }
}