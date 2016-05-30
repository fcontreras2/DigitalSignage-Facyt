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
    * 
    */
    public function findByData($data)
    {
        $where = null;
        $parameters = [];

        if (isset($data['status']) and !is_null($data['status'])) {
            $where = 'i.status = :status';
            $parameters['status'] = $data['status'];
        } else {
            $where = ' i.status > -1';
        }

        if (isset($data['start_date']) and !is_null($data['start_date'])) {
            $where = $where.' and ((i.start_date <= :startDate and :startDate <= i.end_date) or
                (i.start_date <= :endDate and :endDate <= i.end_date))';

            $parameters['startDate'] = $data['start_date'];
            $parameters['endDate'] = $data['end_date'];
        }

        if (isset($data['user']) and !is_null($data['user']) and $data['user']->hasRole('ROLE_USER')) {
            $where = $where. ' and i.user = :userId ';
            $parameters['userId'] = $data['user']->getId();
        }
        
        $query = $this->createQueryBuilder('i')
            ->where($where)->setParameters($parameters);
        if (isset($data['filter']) and !is_null($data['filter'])) {
            if (isset($data['order']) and !is_null($data['order']))
                $query->orderBy('i.'.$data['filter'], $data['order']);
            else
                $query->orderBy('i.'.$data['filter'], 'ASC');
        }

        return $query->getQuery()->getResult();
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
        return $this->createQueryBuilder('i')
            ->innerJoin('i.channels', 'c')
            ->where('
                c.id = :channelId and
                i.status = 0 
            ')
            ->setParameters([
                'channelId' => $channelId
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