<?php

namespace DSFacyt\Core\Application\UseCases\User\EditProfile;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\User;

/**
 * Comando "Editar los datos del usuario"
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/09/2015
 */

class EditProfileCommand implements Command
{
    /**
     * La variable representa el usuario de donde se obtendrán los textos
     * @var $user
     */
    protected $user;

    /**
     * La información a editar del usuario
     * @var $data
     */
    protected $data;

    /**
     *   Constructor de la clase
     *   @param $user User
     */
    public function __construct(User $user = null, $data = null )
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * La función retorna todos los atributos de la clase en un arreglo
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>     *
     * @return Array
     * @version 01/09/2015
     */
    public function getRequest()
    {
        return array(
            'user' => $this->user,
            'data' => $this->data
        );
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}