<?php

namespace DSFacyt\InfrastructureBundle\Entity;

use \DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
* La clase se encarga del manejo de los canales donde se publicaran las noticias
* 
* @author Freddy Contreras <freddycontreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
* @version 26-05-15
*/
class Channel
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $images;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $quick_notes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $texts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $videos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->quick_notes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->texts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->videos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Channel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Channel
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
     * @return Channel
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
     * Add images
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Image $images
     * @return Channel
     */
    public function addImage(\DSFacyt\InfrastructureBundle\Entity\Image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Image $images
     */
    public function removeImage(\DSFacyt\InfrastructureBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add quick_notes
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\QuickNote $quickNotes
     * @return Channel
     */
    public function addQuickNote(\DSFacyt\InfrastructureBundle\Entity\QuickNote $quickNotes)
    {
        $this->quick_notes[] = $quickNotes;

        return $this;
    }

    /**
     * Remove quick_notes
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\QuickNote $quickNotes
     */
    public function removeQuickNote(\DSFacyt\InfrastructureBundle\Entity\QuickNote $quickNotes)
    {
        $this->quick_notes->removeElement($quickNotes);
    }

    /**
     * Get quick_notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuickNotes()
    {
        return $this->quick_notes;
    }

    /**
     * Add texts
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Text $texts
     * @return Channel
     */
    public function addText(\DSFacyt\InfrastructureBundle\Entity\Text $texts)
    {
        $this->texts[] = $texts;

        return $this;
    }

    /**
     * Remove texts
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Text $texts
     */
    public function removeText(\DSFacyt\InfrastructureBundle\Entity\Text $texts)
    {
        $this->texts->removeElement($texts);
    }

    /**
     * Get texts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * Add videos
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Video $videos
     * @return Channel
     */
    public function addVideo(\DSFacyt\InfrastructureBundle\Entity\Video $videos)
    {
        $this->videos[] = $videos;

        return $this;
    }

    /**
     * Remove videos
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Video $videos
     */
    public function removeVideo(\DSFacyt\InfrastructureBundle\Entity\Video $videos)
    {
        $this->videos->removeElement($videos);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }
}
