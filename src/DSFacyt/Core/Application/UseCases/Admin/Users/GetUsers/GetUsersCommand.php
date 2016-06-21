<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Users\GetUsers;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Obtener un conjunto de usuarios por filtros'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class GetUsersCommand implements Command
{
	private $page;

	private $group;

	private $search;

    public function __construct($page = 1, $group = null, $search = null) 
    {
    	$this->page = $page; 
    	$this->group = $group;   
    	$this->search = $search;
    }

    public function getRequest() 
    {
        return [
        	'page' => $this->page,
        	'group' => $this->group,
        	'search' => $this->search
        ];
    }
}