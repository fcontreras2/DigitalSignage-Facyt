<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use DSFacyt\Core\Domain\Repository\TextRepository;
use DSFacyt\InfrastructureBundle\Entity\Text;
use Doctrine\DBAL\Types\Type;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad Text
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbTextRepository extends EntityRepository implements 
    TextRepository  
{
    /**
     * La siguiente función retorna todas las publicaciones de tipo textos dado un usuario
     *
     * @param $user
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @return array
     * @version 01/09/2015
     */
    public function findAllByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->where(' p.user = :user and p.active = true')
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
        return $this->createQueryBuilder('t')
            ->where('
                ((t.start_date <= :startDate and :startDate <= t.end_date) or
                (t.start_date <= :endDate and :endDate <= t.end_date))
                and t.active = true
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
        return $this->createQueryBuilder('t')
            ->where('
                t.status = :status and
                ((t.start_date <= :startDate and :startDate <= t.end_date) or
                (t.start_date <= :endDate and :endDate <= t.end_date))
                and t.active = true
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
            $where = 't.status = :status';
            $parameters['status'] = $data['status'];
        } else {
            $where = ' t.status > -1';
        }

        if (isset($data['start_date']) and !is_null($data['start_date'])) {
            $where = $where.' and ((t.start_date <= :startDate and :startDate <= t.end_date) or
                (t.start_date <= :endDate and :endDate <= t.end_date))';

            $parameters['startDate'] = $data['start_date'];
            $parameters['endDate'] = $data['end_date'];
        }

        if (isset($data['user']) and !is_null($data['user']) and !$data['user']->hasRole('ROLE_ADMIN')) {
            $where = $where. ' and t.user = :userId ';
            $parameters['userId'] = $data['user']->getId();
        }
        
        if ($where)
            $where = $where.' and t.active = true';
        else
            $where = $where.' t.active = true'; 

        $query = $this->createQueryBuilder('t')
            ->where($where)->setParameters($parameters);

        if (isset($data['filter']) and !is_null($data['filter'])) {
            if (isset($data['order']) and !is_null($data['order']))
                $query->orderBy('t.'.$data['filter'], $data['order']);
            else
                $query->orderBy('t.'.$data['filter'], 'ASC');
        }

        return $query->getQuery()->getResult();
    }

    /**
    * Obtiene los datos de los textos que se encuentren publicados por un canal
    *
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param $channelId integer id del canal a buscar
    * @return Array Object
    **/
    public function findActiveByChannel($channelId)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.channels', 'c')
            ->where('
                c.id = :channelId and
                t.status = 2 
                and t.active = true         
            ')
            ->setParameters([
                'channelId' => $channelId
            ])
            ->getQuery()->getResult();    
    }

    public function findLastImportant()
    {
        return $this->createQueryBuilder('t')
            ->where('
                t.important = true 
                and t.active = true
            ')            
            ->orderBy('t.start_date', 'DESC')
            ->setMaxResults(6)
            ->getQuery()->getResult();  
    }

    public function findAllToCheck()
    {
        return $this->createQueryBuilder('t')
            ->where("
                ((
                t.status = 1 and 
                t.start_date <= :current_date)
                or ( t.status = 2 and t.end_date <= :current_date)
                or ( t.status = 0 and t.last_modified >= :last_modified)
                )and t.active = true
            ")
            ->setParameters([
                //'current_time' => (new \DateTime())->format('G:m:s'),
                'current_date' => (new \DateTime()),
                'last_modified' => (new \DateTime('-100 min'))
            ])
            ->getQuery()->getResult();
    }

    public function findActiveFinishedByChannel($channelId)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.channels', 'c')
            ->where('
               c.id = :channelId and
               (t.status = 2 or t.status = 3) and
               t.last_modified >= :last_modified
               and t.active = true
            ')
            ->setParameters([
                'channelId' => $channelId,
                'last_modified' =>  (new \DateTime('-5 min'))
            ])
            ->getQuery()->getResult();
    }

    public function findOldByDays($days)
    {
         return $this->createQueryBuilder('t')
            ->where('
               t.end_date <= :max_date and
               t.status >= 3
               or t.active = false
            ')
            ->setParameters([
                'max_date' =>  (new \DateTime('-'.$days.' days'))
            ])
            ->getQuery()->getResult();
    }

    /**
    * La siguiente función  elimina un texto
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @version 06/10/2015
    */
    public function delete(Text $text)
    {
        $this->getEntityManager()->remove($text);
        $this->getEntityManager()->flush();
    }

    /**
    * Almacena en Bd un objecto de tipo Text
    *
    * @author Freddy Contreras <fredycontreras3@gmail.com>
    * @param Text $text
    */
    public function save(Text $text)
    {
        $this->getEntityManager()->persist($text);
        $this->getEntityManager()->flush($text);
    }
}