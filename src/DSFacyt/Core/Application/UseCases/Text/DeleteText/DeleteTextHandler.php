<?php

namespace DSFacyt\Core\Application\UseCases\Text\DeleteText;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;

/**
 * Clase para ejecutar el caso de uso DeleteText
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 06/10/2015
 */

class DeleteTextHandler implements Handler
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
     * Ejecuta el caso de uso 'Eliminar el texto'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $rpText = $rf->get('Text');
        $text = $rpText->findOneBy(array('id' => $command->getTextId()));

        if ($text) {
            $rpText->delete($text);
            return new ResponseCommandBus(201, 'Ok');
        }

        return new ResponseCommandBus(404, 'No Found');
    }
}