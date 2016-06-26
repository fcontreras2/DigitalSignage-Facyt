<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use DSFacyt\InfrastructureBundle\Entity\Video;
use DSFacyt\Core\Domain\Repository\VideoRepository;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad Video
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbVideoRepository extends EntityRepository implements 
    VideoRepository 
{
    /**
     * La siguiente función retorna todas las publicaciones de tipo videos dado un usuario
     *
     * @param $user
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @return array
     * @version 03/09/2015
     */
    public function findAllByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->where(' p.user = :user')
            ->setParameters( array('user' => $user))
            ->getQuery()->getResult();
    }

    /**
     * Consigue las publicaciones que se publicaran en un rango de fecha
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array
     */
    public function findByStartDateEndDate($startDate, $endDate)
    {
        return $this->createQueryBuilder('v')
            ->where('
                (v.start_date <= :startDate and :startDate <= v.end_date) or
                (v.start_date <= :endDate and :endDate <= v.end_date)
            ')
            ->setParameters([
                'startDate' => $startDate,
                'endDate' => $endDate
            ])
            ->getQuery()->getResult();
    }

    /**
     * Obtiene los datos de las imagenes que se encuentren publicados por un canal
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param $channelId integer id del canal a buscar
     * @return Array Object
     **/
    public function findActiveByChannel($channelId)
    {
        return $this->createQueryBuilder('v')
            ->innerJoin('v.channels', 'c')
            ->where('
                c.id = :channelId and
                v.status = 2
            ')
            ->setParameters([
                'channelId' => $channelId
            ])
            ->getQuery()->getResult();
    }

    /**
     * Retorna las publicaciones dado un estado y un rango de fecha
     *
     * @param $status
     * @param $startDate
     * @param $endDate
     *
     * @return array
     */
    public function findByStatusStartDateEndDate($status, $startDate, $endDate)
    {
        return $this->createQueryBuilder('v')
            ->where('
                v.status = :status and
                ((v.start_date <= :startDate and :startDate <= v.end_date) or
                (v.start_date <= :endDate and :endDate <= v.end_date))
            ')
            ->setParameters([
                'status' => $status,
                'startDate' => $startDate,
                'endDate' => $endDate
            ])
            ->getQuery()->getResult();
    }

    public function findAllToCheck()
    {
        return $this->createQueryBuilder('v')
            ->where("
                (TIME(v.publish_time) <= :current_time and
                v.status = 1 and 
                v.start_date >= :current_date)
                or ( v.status = 2 and v.end_date <= :current_date)
                or ( v.status = 0 and v.last_modified >= :last_modified)
            ")
            ->setParameters([
                'current_time' => (new \DateTime())->format('G:m:s'),
                'current_date' => (new \DateTime()),
                'last_modified' => (new \DateTime('-5 min'))
            ])
            ->getQuery()->getResult();
    }

    /**
     * Almacena en la BD una videon
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param  Video $video
     */
    public function save(Video $video)
    {
        $this->getEntityManager()->persist($video);
        $this->getEntityManager()->flush();
    }
}