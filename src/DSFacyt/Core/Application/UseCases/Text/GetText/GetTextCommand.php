<?php

namespace DSFacyt\Core\Application\UseCases\Text\GetText;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\Text;
/**
 * Comando 'Obtener los datos del texto'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2016
 */

class GetTextCommand implements Command
{

    /**
    * Representa el id del text a consultar
    * @var $iamgeId 
    **/
    private $textId;

    /**
     *   Constructor de la clase
     *   @param integer $textId
     */
    public function __construct($textId)
    {
        $this->textId = $textId;        
    }

    /**
     * La función retorna todos los atributos de la clase en un arreglo
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>     
     * @return Array
     * @version 30/09/2015
     */
    public function getRequest()
    {
        return array(
            'text_id' => $this->textId
        );
    }

}