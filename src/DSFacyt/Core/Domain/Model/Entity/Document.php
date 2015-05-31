<?php

namespace DSFacyt\Core\Domain\Model\Entity;

use DSFacyt\Core\Domain\Adapter\ArrayCollection;

/**
* La clase se encarga del manejo de archivos del sistema
* 
* @author Freddy Contreras <freddycontreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
* @version 20-05-15
*/
class Document
{
    /**
     * Esta propiedad es usada como llave primaria dentro de la DB.
     * 
     * @var Integer
     */
    private $id;
    
    /**
     * Esta propiedad representa un nombre auxiliar del documento
     * 
     * @var String
     */
    private $name;

    /**
     * Esta hace referencia al nombre del archivo 
     * con su extesión (.jpg, .png, .pdf, etc)
     * 
     * @var String
     */
    private $fileName;

    /**
     * Esta propiedad hace referencia al archivo
     * 
     * @var File
     */
    private $file;

    /**
     * Esta propiedad hace referencia al subDominio donde 
     * se almacenará la imagen (ej: /imagenes/.. )
     * 
     * @var String
     */
    private $subDir;

    /**
     * Esta propiedad maneja el conjunto de imagenes asociada a los documentos
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $images;

    /**
     * Esta propiedad maneja el conjunto de vidos asociada a los documentos
     *
     * @var \DSFacyt\Core\Domain\Adapter\ArrayCollection
     */
    private $videos;

    public function __construct() 
    { 
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

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
     * @return DocumentEntity
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
     * @return DocumentEntity
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
    * La función crea un documento
    *
    * @return Void
    */
    public function upload($fileName, $subDir = '')
    {

      if (null === $this->getFile()) {
        return;
      }

      move_uploaded_file($this->getFile(), $this->getUploadRootDir().$subDir.$fileName);

      $this->fileName = $fileName;
      $this->setSubDir($subDir);
    }

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
     * @return \DSFacyt\Core\Domain\Adapter\ArrayCollection 
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
     * @return \DSFacyt\Core\Domain\Adapter\ArrayCollection 
     */
    public function getVideos()
    {
        return $this->videos;
    }
}
