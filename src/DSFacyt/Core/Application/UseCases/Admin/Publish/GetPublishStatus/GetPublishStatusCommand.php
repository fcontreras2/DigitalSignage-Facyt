<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Publish\GetPublishStatus;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtiene un resumen de las publicaciones del sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class GetPublishStatusCommand implements Command
{
    /**
     * @var string Representa el tipo de publicación a buscar (texto, imagen o video)
     */
    private $type;

    /**
     * @var integer Representa el estado de la publación
     */
    private $status;

    /**
     * @var string Fecha inicial de la busqueda
     */
    private $startDate;

    /**
     * @var string Fecha Final de la busqueda
     */
    private $endDate;

    /**
     * @var integer Paginación de la busqueda
     */
    private $page;

    public function __construct($type, $status = 0, $startDate = null, $endDate = null, $page = 1)
    {
        $this->type = $type;
        $this->status = $status;
        $this->startDate = !is_null($startDate) ? new \DateTime($startDate) : new \DateTime();
        $this->endDate = !is_null($endDate) ? new \DateTime($endDate) : (new \DateTime())->modify('+7 days');
        $this->page = $page;
    }

    /**
     *  Método getRequest devuelve un array con los parametros del command
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31-08-2015
     * @return  Array
     */
    public function getRequest()
    {
        return [
            'type' => $this->type,
            'status' => $this->status,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'page' => $this->page
        ];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }
}