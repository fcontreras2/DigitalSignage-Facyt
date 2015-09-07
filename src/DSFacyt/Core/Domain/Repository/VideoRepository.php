<?php 

namespace DSFacyt\Core\Domain\Repository;

/**
*   Interfaz de la VideoRepository
*
*   @author Freddy Contreras <freddycontreras3@gmail.com>
*   @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
*   @version 31-05-2015
*/
interface VideoRepository
{
    /**
     * La siguiente función retorna todas las publicaciones de tipo videos dado un usuario
     *
     * @param $user
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @return array
     * @version 03/09/2015
     */
    public function findAllByUser($user);
}