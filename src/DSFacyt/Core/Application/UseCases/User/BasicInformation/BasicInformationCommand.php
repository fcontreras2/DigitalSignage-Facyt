<?php

namespace DSFacyt\Core\Application\UseCases\User\BasicInformation;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\User;

/**
 * Comando 'Obtener la cantidad de publicaciones hechas por cada tipo de publicación'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 03/09/2015
 */

class BasicInformationCommand implements Command
{
    /**
     * La variable representa el usuario de donde se obtendrán los textos
     * @var $user
     */
    protected $user;

    /**
     *   Constructor de la clase
     *   @param $user User
     */
    public function __construct(User $user = null )
    {
        $this->user = $user;
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
            'user' => $this->user
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
}