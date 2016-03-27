<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use DSFacyt\InfrastructureBundle\Entity\Image;
use DSFacyt\Core\Domain\Repository\ImageRepository;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad Image
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbImageRepository extends EntityRepository implements 
    ImageRepository 
{
    /**
     * La siguiente función retorna todas las publicaciones de tipo imagenes dado un usuario
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
        return $this->createQueryBuilder('i')
            ->where('
                (i.start_date <= :startDate and :startDate <= i.end_date) or
                (i.start_date <= :endDate and :endDate <= i.end_date)
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
        return $this->createQueryBuilder('i')
            ->where('
                i.status = :status and
                ((i.start_date <= :startDate and :startDate <= i.end_date) or
                (i.start_date <= :endDate and :endDate <= i.end_date))
            ')
            ->setParameters([
                'status' => $status,
                'startDate' => $startDate,
                'endDate' => $endDate
            ])
            ->getQuery()->getResult();
    }

    /**
    * La siguiente función  elimina una imagen
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @version 06/10/2015
    */
    public function delete(Image $image)
    {
        $this->getEntityManager()->remove($image);
        $this->getEntityManager()->flush();
    }

    /**
     * Almacena en la BD una imagen
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param  Image $image
     */
    public function save(Image $image)
    {
        $this->getEntityManager()->persist($image);
        $this->getEntityManager()->flush();
    }
}