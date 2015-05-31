<?php

namespace DSFacyt\Core\Domain\Model\Entity;

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
     * Esta propiedad es usada como llave primaria dentro de la DB.
     * 
     * @var Integer
     */
    private $id;
    
    /**
     * Esta propiedad refleja el titulo del Canal
     * 
     * @var String
     */
    private $name;

    /**
     * Esta propiedad refleja la descripción del Canal
     * 
     * @var String
     */
    private $description;

    /**
     * Esta propiedad refleja el estado del canal (activa, revisión, en espera, cancelada)
     * 
     * @var String
     */
    private $status;

    /**
     * Esta propiedad refleja las imagenes asociadas a un canal
     * 
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $images;

    /**
     * Esta propiedad refleja las notas rapidas asociadas a un canal
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $quick_notes;

    /**
     * Esta propiedad refleja los textos asociadas a un canal
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $texts;

    /**
     * Esta propiedad refleja los videos asociados a un canal
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $videos;

    public function __construct() 
    { 
        $this->images = new ArrayCollection();
        $this->quick_notes = new ArrayCollection();
        $this->texts = new ArrayCollection();
        $this->videos = new ArrayCollection();
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
     * @param \DSFacyt\Core\Domain\Model\Entity\Image $images
     * @return Channel
     */
    public function addImage(\DSFacyt\Core\Domain\Model\Entity\Image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Image $images
     */
    public function removeImage(\DSFacyt\Core\Domain\Model\Entity\Image $images)
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
     * @param \DSFacyt\Core\Domain\Model\Entity\QuickNote $quickNotes
     * @return Channel
     */
    public function addQuickNote(\DSFacyt\Core\Domain\Model\Entity\QuickNote $quickNotes)
    {
        $this->quick_notes[] = $quickNotes;

        return $this;
    }

    /**
     * Remove quick_notes
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\QuickNote $quickNotes
     */
    public function removeQuickNote(\DSFacyt\Core\Domain\Model\Entity\QuickNote $quickNotes)
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
     * @param \DSFacyt\Core\Domain\Model\Entity\Text $texts
     * @return Channel
     */
    public function addText(\DSFacyt\Core\Domain\Model\Entity\Text $texts)
    {
        $this->texts[] = $texts;

        return $this;
    }

    /**
     * Remove texts
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Text $texts
     */
    public function removeText(\DSFacyt\Core\Domain\Model\Entity\Text $texts)
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
     * @param \DSFacyt\Core\Domain\Model\Entity\Video $videos
     * @return Channel
     */
    public function addVideo(\DSFacyt\Core\Domain\Model\Entity\Video $videos)
    {
        $this->videos[] = $videos;

        return $this;
    }

    /**
     * Remove videos
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Video $videos
     */
    public function removeVideo(\DSFacyt\Core\Domain\Model\Entity\Video $videos)
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
