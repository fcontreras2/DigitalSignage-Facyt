<?php

namespace DSFacyt\InfrastructureBundle\Entity;

use DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
* La clase se encarga del manejo de imagenes del sistema
* 
* @author Freddy Contreras <freddycontreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
* @version 20-05-15
*/
class Image
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;

    /**
     * @var string
     */
    private $publish_time;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $status = 0;

    /**
     * @var \DateTime
     */
    private $date_create;

    /**
     * @var \DSFacyt\InfrastructureBundle\Entity\User
     */
    private $user;

    /**
     * @var \DSFacyt\InfrastructureBundle\Entity\Document
     */
    private $document;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $channels;

    /**
     * @var string la publicación se considera importante o no
     */
    private $important = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->channels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Image
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
     * @return Image
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
     * @param string $publishTime
     * @return Image
     */
    public function setPublishTime($publishTime)
    {
        $this->publish_time = $publishTime;

        return $this;
    }

    /**
     * Get publish_time
     *
     * @return string 
     */
    public function getPublishTime()
    {
        return $this->publish_time;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Image
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
     * @return Image
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
     * @param integer $status
     * @return Image
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set date_create
     *
     * @param \DateTime $dateCreate
     * @return Image
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

    /**
     * Set user
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\User $user
     * @return Image
     */
    public function setUser(\DSFacyt\InfrastructureBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DSFacyt\InfrastructureBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set document
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Document $document
     * @return Image
     */
    public function setDocument(\DSFacyt\InfrastructureBundle\Entity\Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \DSFacyt\InfrastructureBundle\Entity\Document 
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Add channels
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Channel $channels
     * @return Image
     */
    public function addChannel(\DSFacyt\InfrastructureBundle\Entity\Channel $channels)
    {
        $this->channels[] = $channels;

        return $this;
    }

    /**
     * Remove channels
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Channel $channels
     */
    public function removeChannel(\DSFacyt\InfrastructureBundle\Entity\Channel $channels)
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
     * Set important
     *
     * @param boolean $important
     * @return Image
     */
    public function setImportant($important)
    {
        $this->important = $important;

        return $this;
    }

    /**
     * Get important
     *
     * @return boolean 
     */
    public function getImportant()
    {
        return $this->important;
    }

    /**
    * La función se encarga de actualizar la entidad
    * dado un array de datos
    **/
    public function updateObject($data)
    {
        if (isset($data['title']))
            $this->title = $data['title'];

        if (isset($data['publish_time']))
            $this->publish_time = $data['publish_time'];

        if (isset($data['start_date']))
            $this->start_date = \DateTime::createFromFormat('d/m/Y',$data['start_date']);

        if (isset($data['end_date']))
            $this->end_date = \DateTime::createFromFormat('d/m/Y',$data['end_date']);

        if (isset($data['description']))
            $this->description = $data['description'];     
    }
}
