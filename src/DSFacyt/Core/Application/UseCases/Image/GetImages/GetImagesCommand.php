<?php

namespace DSFacyt\Core\Application\UseCases\Image\GetImages;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Domain\Model\Entity\User;

/**
 * Comando 'Obtener las imagenes publicadas'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 12/10/2015
 */

class GetImagesCommand implements Command
{
    /**
     * La variable representa el usuario de donde se obtendrán las imagenes
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
     * @author Freddy Contreras <freddycontreras3@gmail.com>  
     * @return Array
     * @version 12/10/2015
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