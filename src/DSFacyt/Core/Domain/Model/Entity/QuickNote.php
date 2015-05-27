<?php

namespace DSFacyt\Core\Domain\Model\Entity;

/**
* La clase se encarga del manejo de notas rapidas del sistema
* 
* @author Freddy Contreras <freddycontreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
* @version 26-05-15
*/
class QuickNote
{
    public function __construct() { }

    /**
     * Esta propiedad es usada como llave primaria dentro de la DB.
     * 
     * @var Integer
     */
    protected $id;
    
    /**
     * Esta propiedad refleja la fecha de inicio a publicar 
     * 
     * @var Date
     */
    protected $start_date;

    /**
     * Esta propiedad refleja la fecha de final a publicar 
     * 
     * @var Date
     */
    protected $end_date;

    /**
     * Esta propiedad refleja el titulo de la publicación
     * 
     * @var String
     */
    protected $title;

    /**
     * Esta propiedad refleja la información a publicar
     * 
     * @var String
     */
    protected $info;


    /**
     * Esta propiedad refleja el estado de la publicación (activa, revisión, en espera, cancelada)
     * 
     * @var String
     */
    protected $status;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return QuickNote
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $endDate
     * @return QuickNote
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return QuickNote
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set info
     *
     * @param string $info
     * @return QuickNote
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return QuickNote
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
