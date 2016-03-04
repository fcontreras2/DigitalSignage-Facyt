<?php

namespace DSFacyt\Core\Application\UseCases\Admin\GetResumen;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtiene un resumen de las publicaciones del sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class GetResumenCommand implements Command
{
    /**
     * @var Fecha inicial de obtener el resumen de publicaciones
     */
    private $startDate;

    /**
     * @var Fecha final de obtener el resumen de publicaciones
     */
    private $endDate;

    /**
     * constructor de la clase
     *
     * @param null $startDate
     * @param null $endDate
     */
    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = !is_null($startDate) ? new \DateTime($startDate) : new \DateTime();
        $this->endDate = !is_null($endDate) ? new \DateTime($endDate) : (new \DateTime())->modify('+7 days');
    }

    public function getRequest()
    {
        return [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ];
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
}