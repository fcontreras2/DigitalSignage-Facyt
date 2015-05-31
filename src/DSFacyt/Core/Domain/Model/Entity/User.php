<?php 

namespace DSFacyt\Core\Domain\Model\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
 * La clase se encarga de manejar los usuarios del sistema
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31-05-15
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;
    
    /**
     * La propiedad representa la cedula de identidad del usuario
     * 
     * @var integer
     */
    protected $indentity_card;

    /**
     * La propiedad representa el nombre del usuario
     * 
     * @var string
     */
    protected $name;

    /**
     * La propiedad representa la escuela del usuario
     * 
     * @var string
     */
    protected $school;

    /**
     * La propiedad representa el télefono del usuario
     * 
     * @var string
     */
    protected $phone;

    /**
     * La propiedad representa las imagenes del usuario
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $images;

    /**
     * La propiedad representa las notas rápidas del usuario
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $quick_notes;

    /**
     * La propiedad representa los textos del usuario
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $texts;

    /**
     * La propiedad representa los videos del usuario
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $videos;


    public function __construct() 
    { 
        parent::__construct();

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
     * Set indentity_card
     *
     * @param integer $indentityCard
     * @return User
     */
    public function setIndentityCard($indentityCard)
    {
        $this->indentity_card = $indentityCard;

        return $this;
    }

    /**
     * Get indentity_card
     *
     * @return integer 
     */
    public function getIndentityCard()
    {
        return $this->indentity_card;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set school
     *
     * @param string $school
     * @return User
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string 
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add images
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Image $images
     * @return User
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
     * @return \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add quick_notes
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\QuickNote $quickNotes
     * @return User
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
     * @return \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    public function getQuickNotes()
    {
        return $this->quick_notes;
    }

    /**
     * Add texts
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Text $texts
     * @return User
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
     * @return \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * Add videos
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Video $videos
     * @return User
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
     * @return \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    public function getVideos()
    {
        return $this->videos;
    }
}
