<?php

namespace DSFacyt\Core\Application\UseCases\Display\GetDataTransmition;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtiene la información a transmitir en un canal'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */
class GetDataTransmitionCommand implements Command
{

    /**
    * @var string representa el slug del canal
    */
    private $slug;

    public function __construct($slug = null)
    {
        $this->slug =  $slug;
    }

    public function getRequest()
    {
        return [
            'slug' => $this->slug
        ];
    }
}
