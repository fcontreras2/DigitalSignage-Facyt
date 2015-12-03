<?php

namespace DSFacyt\Core\Application\UseCases\Text\GetTexts;

use DSFacyt\Core\Application\Contract\Command;
use DSFacyt\Core\Domain\Model\Entity\User;

/**
 * Comando 'Obtener los textos publicados'
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 01/09/2015
 */

class GetTextsCommand implements Command
{
    /**
     * La variable representa el usuario de donde se obtendrán los textos
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
    public function __construct(User $user = null, $page = null )
    {
        $this->user = $user;
        $this->page = $page;
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