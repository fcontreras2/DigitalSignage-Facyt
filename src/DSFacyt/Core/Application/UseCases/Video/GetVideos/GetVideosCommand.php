<?php

namespace DSFacyt\Core\Application\UseCases\Video\GetVideos;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\InfrastructureBundle\Entity\User;

/**
 * Comando 'Obtener las videones publicadas'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 12/10/2015
 */

class GetVideosCommand implements Command
{
    /**
     * La variable representa el usuario de donde se obtendrán las videones
     * @var $user
     */
    protected $user;

    /**
     * @var Representa la página a cargar al momento de hacer la paginación
     */
    protected $page;


    /**
     *   Constructor de la clase
     *   @param $user User
     */
    public function __construct(User $user = null, $page = null)
    {
        $this->user = $user;
        $this->page = $page;
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
            'user' => $this->user,
            'page' => $this->page
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
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param integer $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }
}