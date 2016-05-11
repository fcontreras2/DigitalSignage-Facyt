<?php
namespace DSFacyt\Core\Domain\Model\Entity;

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
     * Esta propiedad es usada como llave primaria dentro de la DB.
     * 
     * @var Integer
     */
    protected $id;
    
    /**
     * Esta propiedad representa un nombre auxiliar del documento
     * 
     * @var String
     */
    public $name;

    /**
     * Esta hace referencia al nombre del archivo 
     * con su extesión (.jpg, .png, .pdf, etc)
     * 
     * @var String
     */
    public $fileName;

    /**
     * Esta propiedad hace referencia al archivo
     * 
     */
    private $file;

    /*
     * Esta propiedad hace referencia al subDominio donde 
     * se almacenará la imagen (ej: /imagenes/.. )
     */
    private $subDir;

    /**
     * constructor
     */
    public function __construct() { }

    public function setFile($file = null)
    {
      $this->file = $file;
    }

    public function getFile()
    {
      return $this->file;
    }
    
    /**
     * Set subDir
     *
     * @param string $subDir
     * @return DocumentEntity
     */ 
    public function setSubDir($subDir = null)
    {
      $this->subDir = $subDir;
    }

    /**
     * Get subDir
     *
     * @return String
     */
    public function getSubDir()
    {
      return $this->subDir;
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
     *
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
     *
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
    * La función retorna la dirección absoluta del archivo
    *
    * @return string
    */
    public function getAbsolutePath()
    {
      return null === $this->fileName
      ? null
      : $this->getUploadRootDir().'/'.$this->fileName;
    }

    /**
    * La función retorna la dirección archivo
    *
    * @return string
    */
    public function getWebPath()
    {
      return null === $this->fileName
      ? null
      : $this->getSubDir().'/'.$this->fileName;
    }

    /**
    * La función retorna la dirección absoluta del subdominio del archivo
    *
    * @return string
    */
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
      return $_SERVER['DOCUMENT_ROOT'].$this->getSubDir();
    }
    
    /**
    * La función crea un documento en el directorio
    *
    * @param String $typeFile 
    * @param String $fileName
    * @param String $subDir
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @version 25/06/2015
    * @return Void
    */
    public function upload($typeFile = 'image', $subDir = '', $nameFile = null)
    {

        if (null === $this->getFile()) {
            return;
        }

        $pathTypeFile = $this->getPathTypeFile($typeFile);
        $this->setSubDir($pathTypeFile.$subDir);

        // Si no existe el directorio se crea el directorio
        if (!file_exists($this->getUploadRootDir())) {
            mkdir($this->getUploadRootDir(),0755, true);
        }

        if (is_null($nameFile))
            $nameFile = substr(time() + rand(), 0, 14);
        else{
            $nameFile = $nameFile.substr(time()+rand(), 0, 14);
        }
        
        $extension = $this->getFile()->guessExtension();
        $path = $this->getUploadRootDir().$nameFile.'.'.$extension;


        $this->setFileName($subDir.$nameFile.'.'.$extension);
        move_uploaded_file($this->getFile(), $path);
    }

    /**
    * La siguiente función retorna el directorio principal 
    * del documento según el tipo de documento (imagen, video, pdf, etc)
    * 
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @version 25/06/2015
    */
    private function getPathTypeFile($type)
    {
        $response = 'image';

        switch ($type) {
            case 'image':
                $response  = '/uploads/images/';
                break;
            case 'video':
                $response = '/uplods/videos/';
                break;            
            default:
                $response  = '/uploads/images/';
                break;
        }

        return $response;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $images;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $videos;


    /**
     * Add images
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Image $images
     * @return Document
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
     * Add videos
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\Video $videos
     * @return Document
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

    public function removeFile($type = 'image')
    {
        $pathDocument = $_SERVER['DOCUMENT_ROOT'].$this->getPathTypeFile($type).$this->getFileName();
        if (file_exists($pathDocument))
            unlink($pathDocument);
    }
    /**
     * @var \DSFacyt\Core\Domain\Model\Entity\User
     */
    private $image_profile;


    /**
     * Set image_profile
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\User $imageProfile
     * @return Document
     */
    public function setImageProfile(\DSFacyt\Core\Domain\Model\Entity\User $imageProfile = null)
    {
        $this->image_profile = $imageProfile;

        return $this;
    }

    /**
     * Get image_profile
     *
     * @return \DSFacyt\Core\Domain\Model\Entity\User 
     */
    public function getImageProfile()
    {
        return $this->image_profile;
    }
    /**
     * @var \DSFacyt\Core\Domain\Model\Entity\User
     */
    private $user_image_profile;


    /**
     * Set user_image_profile
     *
     * @param \DSFacyt\Core\Domain\Model\Entity\User $userImageProfile
     * @return Document
     */
    public function setUserImageProfile(\DSFacyt\Core\Domain\Model\Entity\User $userImageProfile = null)
    {
        $this->user_image_profile = $userImageProfile;

        return $this;
    }

    /**
     * Get user_image_profile
     *
     * @return \DSFacyt\Core\Domain\Model\Entity\User 
     */
    public function getUserImageProfile()
    {
        return $this->user_image_profile;
    }
}
