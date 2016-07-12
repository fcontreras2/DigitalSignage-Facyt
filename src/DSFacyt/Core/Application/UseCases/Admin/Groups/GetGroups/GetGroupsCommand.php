<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Groups\GetGroups;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtener los grupos de usuarios'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 3/03/2016
 */
class GetGroupsCommand implements Command
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