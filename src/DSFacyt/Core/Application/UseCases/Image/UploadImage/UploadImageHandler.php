<?php

namespace DSFacyt\Core\Application\UseCases\Image\UploadImage;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso GetImages
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 12/10/2015
 */

class UploadImageHandler implements Handler
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
     * Ejecuta el caso de uso 'Publicar una imagen en el sistema'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpImage = $rf->get('Image');
        $image = $command->getImage();
        
        try {
            $image->getDocument()->setName($image->getTitle());
            $image->setStatus(0);
            $fileName = strtolower(str_replace(' ','_',$image->getTitle())).'_';
            $image->getDocument()->upload('image', $command->getIndentityFolderUser().'/',$fileName);            
            $rpImage->save($image);

        } catch(\Exception $e) {
            return new ResponseCommandBus(500, 'Error Server', $e->getMessage());
        }

        return new ResponseCommandBus(201, 'Ok');
    }
}   