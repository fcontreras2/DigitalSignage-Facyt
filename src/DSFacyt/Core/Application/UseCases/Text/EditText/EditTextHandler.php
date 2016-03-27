<?php

namespace DSFacyt\Core\Application\UseCases\Text\EditText;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;
use Proxies\__CG__\DSFacyt\InfrastructureBundle\Entity\Text;

/**
 * Clase para ejecutar el caso de uso EditText
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 01/09/2015
 */

class EditTextHandler implements Handler
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
     * Ejecuta el caso de uso 'Editar el texto'
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
            $command->setEntityText($text);
            return new ResponseCommandBus(201, 'Ok');
        }

        return new ResponseCommandBus(404, 'No Found');
    }
}