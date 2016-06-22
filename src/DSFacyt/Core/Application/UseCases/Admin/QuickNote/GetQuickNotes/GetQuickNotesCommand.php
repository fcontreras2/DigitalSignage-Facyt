<?php

namespace DSFacyt\Core\Application\UseCases\Admin\QuickNote\GetQuickNotes;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtener las notas rápidas del establecimiento'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 3/03/2016
 */

class GetQuickNotesCommand implements Command
{
	private $page;

	public function __construct($page = 1) 
    {
    	$this->page = $page;    	
    }

    public function getRequest() 
    {
        return [
        	'page' => $this->page        	
        ];
    }
}