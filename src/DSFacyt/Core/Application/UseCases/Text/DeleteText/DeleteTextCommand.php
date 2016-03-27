<?php

namespace DSFacyt\Core\Application\UseCases\Text\DeleteText;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Text;
/**
 * Comando 'Eliminar los datos de un texto'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 30/09/2015
 */

class DeleteTextCommand implements Command
{
    /**
     * La variable representa el id del texto a editar
     * @var integer $textId
     */
    protected $textId;

    /**
     *   Constructor de la clase
     *   @param integer $textId
     */
    public function __construct($textId = null)
    {
        $this->textId = $textId;        
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
            'text_id' => $this->textId
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
}