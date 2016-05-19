<?php 

namespace DSFacyt\Core\Domain\Repository;

/**
*   Interfaz de la TextRepository
*
*   @author Freddy Contreras <freddycontreras3@gmail.com>
*   @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
*   @version 31-05-2015
*/
interface TextRepository
{
    /**
     * La siguiente función retorna todas las publicaciones de tipo textos dado un usuario
     *
     * @param $user
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @return array
     * @version 01/09/2015
     */
    public function findAllByUser($user);

    /**
     * Consigue las publicaciones que se publicaran en un rango de fecha
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array
     */
    public function findByStartDateEndDate($startDate, $endDate);

    /**
     * Retorna las publicaciones dado un estado y un rango de fecha
     *
     * @param $status
     * @param $startDate
     * @param $endDate
     *
     * @return array
     */
    public function findByStatusStartDateEndDate($status, $startDate, $endDate);

    /**
    * Obtiene los datos de los textos que se encuentren publicados por un canal
    *
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param $channelId integer id del canal a buscar
    * @return Array Object
    **/
    public function findActiveByChannel($channelId);
}