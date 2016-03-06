<?php

namespace DSFacyt\Core\Domain\Model\Entity;

use \DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
* La clase se encarga del manejo de Videos del sistema
* 
* @author Freddy Contreras <freddycontreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
* @version 20-05-15
*/
class Video
{
    /**
     * Esta propiedad es usada como llave primaria dentro de la DB.
     * 
     * @var Integer
     */
    protected $id;
    
    /**
     * Esta propiedad refleja la fecha inicio a publicar
     * 
     * @var Date
     */
    private $start_date;

    /**
     * Esta propiedad refleja la fecha final a publicar
     * 
     * @var Date
     */
    private $end_date;

    /**
     * Esta propiedad refleja la hora a publicar
     * 
     * @var Time
     */
    private $publish_time;

    /**
     * Esta propiedad refleja el titulo de la publicación
     * 
     * @var String
     */
    private $title;

    /**
     * Esta propiedad refleja la descripción del video publicada
     * 
     * @var String
     */
    private $description;

    /**
     * Esta propiedad refleja el estado de la publicación (activa, revisión, en espera, cancelada)
     *
     * @var string
     */
    private $status;

    /**
     * Esta propiedad refleja el estado de la publicación (Pendiente 0, Corregir Publicación 1, Aceptada 2, Cancelada 3, Finalizada 4)
     *
     * @var \DSFacyt\Core\Domain\Model\Entity\User
     */
    private $user;

    /**
     * Esta propiedad representa los canales donde se mostrará la publicación
     * 
     * @var \DSFacyt\Core\Domain\Model\Entity\Channel
     */
    private $channels;

    /**
     * Esta propiedad refleja el documento asociada el video
     *
     * @var \DSFacyt\Core\Domain\Model\Entity\Document
     */
    private $document;

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
     * @return Video
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
     * @return Video
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
     * Set publish_time
     *
     * @param \DateTime $publishTime
     * @return Video
     */
    public function setPublishTime($publishTime)
    {
        $this->publish_time = $publishTime;

        return $this;
    }

    /**
     * Get publish_time
     *
     * @return \DateTime 
     */
    public function getPublishTime()
    {
        return $this->publish_time;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Video
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
     * Set description
     *
     * @param string $description
     * @return Video
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Video
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
     * @return Video
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
     * Set document
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Document $document
     * @return Video
     */
    public function setDocument(\DSFacyt\Core\Domain\Model\Entity\Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \DSFacyt\Core\Domain\Model\Entity\Document 
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Add channels
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Channel $channels
     * @return Video
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
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChannels()
    {
        return $this->channels;
    }
   
    /**
     * Set date_create
     *
     * @param \DateTime $dateCreate
     * @return Video
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
