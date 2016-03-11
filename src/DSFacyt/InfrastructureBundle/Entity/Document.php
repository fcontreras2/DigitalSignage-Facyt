<?php
namespace DSFacyt\InfrastructureBundle\Entity;

/**
 * La clase se encarga del manejo de archivos del sistema
 *
 * Se define una clase y una serie de propiedades para el manejo de archivos del sistema.
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 13-05-15
 */
class Document
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
    private $fileName;

    /**
     * @var \DSFacyt\InfrastructureBundle\Entity\User
     */
    private $user_image_profile;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $images;

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
     * @return Document
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
     * Set fileName
     *
     * @param string $fileName
     * @return Document
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set user_image_profile
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\User $userImageProfile
     * @return Document
     */
    public function setUserImageProfile(\DSFacyt\InfrastructureBundle\Entity\User $userImageProfile = null)
    {
        $this->user_image_profile = $userImageProfile;

        return $this;
    }

    /**
     * Get user_image_profile
     *
     * @return \DSFacyt\InfrastructureBundle\Entity\User 
     */
    public function getUserImageProfile()
    {
        return $this->user_image_profile;
    }

    /**
     * Add images
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Image $images
     * @return Document
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
     * Add videos
     *
     * @param \DSFacyt\InfrastructureBundle\Entity\Video $videos
     * @return Document
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
