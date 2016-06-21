<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use DSFacyt\InfrastructureBundle\Entity\User;
use DSFacyt\Core\Domain\Repository\UserRepository;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad User
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbUserRepository extends EntityRepository implements 
    UserRepository  
{
    /**
     * La siguiente función  registra un usuario
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 06/10/2015
     */
    public function save(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findByFilter($array)
    {
        $where = null;
        $parameters = [];
        $query = $this->createQueryBuilder('u');
        return $query->getQuery()->getResult();

/*
        if)

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

        if (isset($data['user']) and !is_null($data['user']) and !$data['user']->hasRole('ROLE_ADMIN')) {
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

        return $query->getQuery()->getResult();*/

    }
}