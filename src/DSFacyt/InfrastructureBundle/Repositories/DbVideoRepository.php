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