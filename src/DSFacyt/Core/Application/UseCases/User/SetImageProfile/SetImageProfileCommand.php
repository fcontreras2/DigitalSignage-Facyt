<?php
namespace DSFacyt\Core\Application\UseCases\User\SetImageProfile;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\User;

/**
 * Comando "Asignar la imagen de perfil del usuario"
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/09/2015
 */

class SetImageProfileCommand implements Command
{
    protected $image;

    protected $user;

    public function __construct($image = null, $user = null)
    {
    	$this->image = $image;
    	$this->user = $user;
    }

    public function getRequest()
    {
    	return [
    		'image' => $this->image,
    		'user' => $this->user
    	];
    }
}