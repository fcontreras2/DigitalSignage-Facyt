<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Groups\EditGroup;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Editar un grupo de usuario'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 3/03/2016
 */
class EditGroupCommand implements Command
{
	private $groupId;

    private $permissons;

	public function __construct($groupId, $permissons) 
    {
    	$this->groupId = $groupId;    	
        $this->permissons = $permissons;
    }

    public function getRequest() 
    {
        return [
        	'groupId' => $this->groupId,
            'permissons' => $this->permissons
        ];
    }
}