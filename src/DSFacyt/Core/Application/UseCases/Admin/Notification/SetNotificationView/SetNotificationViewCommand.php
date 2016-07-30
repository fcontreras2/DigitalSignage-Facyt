<?php

namespace DSFacyt\Core\Application\UseCases\Admin\Notification\SetNotificationView;

use DSFacyt\Core\Application\Contract\Command;

/**
 * Comando 'Revisa las notificaciones'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/03/2016
 */

class SetNotificationViewCommand implements Command
{
	private $id;

	public function __construct($id)
	{
		$this->id = $id;
	}
    public function getRequest() { return ['id' => $this->id]; }
}