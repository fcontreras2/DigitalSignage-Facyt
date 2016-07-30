<?php 

namespace DSFacyt\InfrastructureBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use DSFacyt\InfrastructureBundle\Entity\Nofitication;
use DSFacyt\Core\Domain\Repository\NotificationRepository;

/**
* La clase se declaran los metodos y funciones que implementan
* el repositorio de la entidad Nofitifactions
*
* @author Freddy Contreras <freddy.contreras3@gmail.com>
* @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
* @version 31/05/15
*/

class DbNotificationRepository extends EntityRepository implements 
    NotificationRepository 
{

    /**
    * Obtener las nofiticaciones recientes para el admin
    * 
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    */
    public function findNotViewNotifications()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.view')
            ->getQuery()->getResult();
    }
    
    /**
    * La siguiente función  elimina una Notificación
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @version 06/10/2015
    */
    public function delete($notification)
    {
        $this->getEntityManager()->remove($notification);
        $this->getEntityManager()->flush();
    }

    /**
     * Almacena en la BD una Notificación
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param  Notification $notification
     */
    public function save($notification)
    {
        $this->getEntityManager()->persist($notification);
        $this->getEntityManager()->flush();
    }
}