<?php 

namespace DSFacyt\InfrastructureBundle\Entity;

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
     * @var string
     */
    private $last_name;

    /**
     * @var integer
     */
    private $indentity_card;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var \DSFacyt\InfrastructureBundle\Entity\Document
     */
    private $image_profile;

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
     * @var \DSFacyt\InfrastructureBundle\Entity\School
     */
    private $school;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->roles = array();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->quick_notes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->texts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->videos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Implementación de una lista de roles para los usuarios 
     * 
     * @throws Exception
     * @param Rol $rol 
     */
    public function addRole($rol)
    {
        switch($rol){
            case 0:
                array_push($this->roles, 'ROLE_ADMIN');
                break;            
            default:
                array_push($this->roles, 'ROLE_USER');
                break;
        }
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
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
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
     * Set image_profile
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Document $imageProfile
     * @return User
     */
    public function setImageProfile(\DSFacyt\InfrastructureBundle\Entity\Document $imageProfile = null)
    {
        $this->image_profile = $imageProfile;

        return $this;
    }

    /**
     * Get image_profile
     *
     * @return \DSFacyt\InfrastructureBundle\Entity\Document 
     */
    public function getImageProfile()
    {
        return $this->image_profile;
    }

    /**
     * Add images
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Image $images
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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

    /**
     * Set school
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\School $school
     * @return User
     */
    public function setSchool(\DSFacyt\InfrastructureBundle\Entity\School $school = null)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \DSFacyt\InfrastructureBundle\Entity\School 
     */
    public function getSchool()
    {
        return $this->school;
    }
}
