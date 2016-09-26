<?php

namespace DSFacyt\InfrastructureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 */
class Notification
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $current_time;

    /**
     * @var boolean
     */
    private $view = false;

    /**
     * @var string
     */
    private $publish_type;

    /**
     * @var integer
     */
    private $publish_id;

    /**
     * @var array
     */
    private $data;

    public function __construct() 
    {
        $this->last_modified = new \DateTime();
        $this->data = [];
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
     * Set current_time
     *
     * @param \DateTime $currentTime
     * @return Notification
     */
    public function setCurrentTime($currentTime)
    {
        $this->current_time = $currentTime;
        return $this;
    }

    /**
     * Get current_time
     *
     * @return \DateTime 
     */
    public function getCurrentTime()
    {
        return $this->current_time;
    }

    /**
     * Set view
     *
     * @param boolean $view
     * @return Notification
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return boolean 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set publish_type
     *
     * @param string $publishType
     * @return Notification
     */
    public function setPublishType($publishType)
    {
        $this->publish_type = $publishType;

        return $this;
    }

    /**
     * Get publish_type
     *
     * @return string 
     */
    public function getPublishType()
    {
        return $this->publish_type;
    }

    /**
     * Set publish_id
     *
     * @param integer $publishId
     * @return Notification
     */
    public function setPublishId($publishId)
    {
        $this->publish_id = $publishId;

        return $this;
    }

    /**
     * Get publish_id
     *
     * @return integer 
     */
    public function getPublishId()
    {
        return $this->publish_id;
    }

    /**
     * Set data
     *
     * @param array $data
     * @return Notification
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array 
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * @var \DateTime
     */
    private $last_modified;


    /**
     * Set last_modified
     *
     * @param \DateTime $lastModified
     * @return Notification
     */
    public function setLastModified($lastModified)
    {
        $this->last_modified = $lastModified;

        return $this;
    }

    /**
     * Get last_modified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->last_modified;
    }
    /**
     * @var string
     */
    private $event = '';


    /**
     * Set event
     *
     * @param string $event
     * @return Notification
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string 
     */
    public function getEvent()
    {
        return $this->event;
    }
}
