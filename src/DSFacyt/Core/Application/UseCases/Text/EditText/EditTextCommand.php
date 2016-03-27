<?php

namespace DSFacyt\Core\Application\UseCases\Text\EditText;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Text;
/**
 * Comando 'Editar los datos de un texto'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 30/09/2015
 */

class EditTextCommand implements Command
{
    /**
     * La variable representa el id del texto a editar
     * @var integer $textId
     */
    protected $textId;

    /**
     * El atributo de la clase representa el texto el cual se va editar
     * @var Text $entityText
     */
    protected $entityText;

    /**
     *   Constructor de la clase
     *   @param integer $textId
     */
    public function __construct($textId = null, $entityText  = null)
    {
        $this->textId = $textId;
        $this->entityText = $entityText;
    }

    /**
     * La función retorna todos los atributos de la clase en un arreglo
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>     *
     * @return Array
     * @version 30/09/2015
     */
    public function getRequest()
    {
        return array(
            'text_id' => $this->textId,
            'entityText' => $this->entityText
        );
    }

    /**
     * Método Get del atributo $textId
     * @return integer
     */
    public function getTextId()
    {
        return $this->textId;
    }

    /**
     * Método Set del atributo $textId
     * @param integer $textId
     */
    public function setTextId($textId)
    {
        $this->textId = $textId;
    }

    /**
     * Método Get del atributo $entityText
     * @return Text
     */
    public function getEntityText()
    {
        return $this->entityText;
    }

    /**
     * Método Set del atributo $entityText
     * @param Text $entityText
     */
    public function setEntityText(Text $entityText)
    {
        $this->entityText = $entityText;
    }
}