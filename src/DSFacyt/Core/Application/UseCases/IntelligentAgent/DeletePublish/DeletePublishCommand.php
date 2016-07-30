<?php

namespace DSFacyt\Core\Application\UseCases\IntelligentAgent\DeletePublish;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando del 'Eliminando publicaciones viejas del sistema'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 02/02/2016
 */

class DeletePublishCommand implements Command
{
	private $maxDate;

	public function __construct($maxDate)
	{
		$this->maxDate = $maxDate;
	}
    public function getRequest() 
    {
    	return ['maxDate' => $this->maxDate];
    }
}