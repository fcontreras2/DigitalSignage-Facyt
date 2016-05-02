<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use DSFacyt\Core\Domain\Repository\TextRepository;
use DSFacyt\InfrastructureBundle\Entity\Text;

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
        return $this->createQueryBuilder('t')
            ->where('
                (t.start_date <= :startDate and :startDate <= t.end_date) or
                (t.start_date <= :endDate and :endDate <= t.end_date)
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
            ')
            ->setParameters([
                'status' => $status,
                'startDate' => $startDate,
                'endDate' => $endDate
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