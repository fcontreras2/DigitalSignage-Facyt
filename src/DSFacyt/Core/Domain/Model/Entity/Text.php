<?php

namespace DSFacyt\Core\Domain\Model\Entity;

use DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
* La clase se encarga del manejo de los textos a publicar
* 
* @author Freddy Contreras <freddycontreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
* @version 26-05-15
*/
class Text
{
    /**
     * Esta propiedad es usada como llave primaria dentro de la DB.
     * 
     * @var Integer
     */
    private $id;
    
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

    public function __construct() 
    { 
        $this->channels = new ArrayCollection();        
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
     * @return Text
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
     * @return Text
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
     * @return Text
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
     * @return Text
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
     * @return Text
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
     * @return Text
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
     * @return Text
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
     * @return Text
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
}
