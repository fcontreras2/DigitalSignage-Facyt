<?php

namespace DSFacyt\Core\Domain\Model\Entity;

use \DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
* La clase se encarga del manejo de notas rapidas del sistema
* 
* @author Freddy Contreras <freddycontreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
* @version 26-05-15
*/
class QuickNote
{
    /**
     * Esta propiedad es usada como llave primaria dentro de la DB.
     * 
     * @var Integer
     */
    private $id;
    
    /**
     * Esta propiedad refleja la fecha de inicio a publicar 
     * 
     * @var Date
     */
    private $start_date;

    /**
     * Esta propiedad refleja la fecha de final a publicar 
     * 
     * @var Date
     */
    private $end_date;

    /**
     * Esta propiedad refleja el titulo de la publicación
     * 
     * @var String
     */
    private $title;

    /**
     * Esta propiedad refleja la información a publicar
     * 
     * @var String
     */
    private $info;

    /**
     * Esta propiedad refleja el estado de la publicación (activa, revisión, en espera, cancelada)
     * 
     * @var String
     */
    private $status;

    /**
     * Esta propiedad representa los canales donde se mostrará la publicación
     *
     * @var \DSFacyt\Core\Domain\Model\Entity\Channel
     */
    private $channels;

    /**
     * Esta propiedad representa al usuario al que le pertenece la publicación
     *
     * @var \DSFacyt\Core\Domain\Model\Entity\User
     */
    private $user;

    /**
     * Fecha de creación de la publicación
     * @var \DateTime
     */
    private $date_create;

    public function __construct() 
    { 
        $this->channels = new ArrayCollection();
        $this->date_create = new  \DateTime();
    }


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

    /**
     * Set user
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\User $user
     * @return QuickNote
     */
    public function setUser(\DSFacyt\Core\Domain\Model\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DSFacyt\Core\Domain\Model\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add channels
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Channel $channels
     * @return QuickNote
     */
    public function addChannel(\DSFacyt\Core\Domain\Model\Entity\Channel $channels)
    {
        $this->channels[] = $channels;

        return $this;
    }

    /**
     * Remove channels
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Channel $channels
     */
    public function removeChannel(\DSFacyt\Core\Domain\Model\Entity\Channel $channels)
    {
        $this->channels->removeElement($channels);
    }

    /**
     * Get channels
     *
     * @return \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Set date_create
     *
     * @param \DateTime $dateCreate
     * @return QuickNote
     */
    public function setDateCreate($dateCreate)
    {
        $this->date_create = $dateCreate;

        return $this;
    }

    /**
     * Get date_create
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }
}
