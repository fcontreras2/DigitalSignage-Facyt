<?php

namespace DSFacyt\Core\Application\UseCases\Admin\QuickNote\GetQuickNotes;

use DSFacyt\Core\Application\Contract\Handler;
use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Application\Contract\RepositoryFactoryInterface;
use DSFacyt\Core\Application\Contract\ResponseCommandBus;


/**
 * Clase del caso de uso 'Obtener los datos de las notas rápidas'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2015
 */

class GetQuickNotesHandler implements Handler
{
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
     * Handler del caso de uso 'Obtener los datos de las notas rápidas'
     *
     * @param Command $command Objeto Command contenedor de la solicitud del usuario
     * @param RepositoryFactoryInterface  $rf
     *
     * @return \DSFacyt\Core\Application\Contract\ResponseCommandBus
     */
    public function handle(Command $command, RepositoryFactoryInterface $rf = null)
    {
        $request = $command->getRequest();
        $rpQuickNote = $rf->get('QuickNote');
        $response = ['quick_notes' => []];

        $quickNotes = $rpQuickNote->findAll();

        if ($quickNotes) {

            $response['pagination'] = $this->pagination->generate($quickNotes,$request['page']);
            $auxQuick = [];
            foreach ($quickNotes as $currentQuickNote) {
                $auxQuick['id'] = $currentQuickNote->getId();
                $auxQuick['title'] = $currentQuickNote->getTitle();
                $auxQuick['start_date'] = $currentQuickNote->getStartDate()->format('d-m-Y');
                $auxQuick['end_date'] = $currentQuickNote->getEndDate()->format('d-m-Y');
                $auxQuick['info'] = $currentQuickNote->getInfo();
                $auxQuick['status'] = $currentQuickNote->getStatus();
                $response['quick_notes'][] = $auxQuick;
            }

            return new ResponseCommandBus(200, 'Ok', $response);
        }

        return new ResponseCommandBus(404, 'Not Found');
    }
}