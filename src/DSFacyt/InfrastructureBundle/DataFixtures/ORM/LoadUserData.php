<?php
namespace DSFacyt\InfrastructureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DSFacyt\Core\Domain\Model\Entity\User;

/**
 * Clase LoadUserData "DataFixtures".
 *
 * La clase carga los datos de prueba del sistema de los usuarios
 *
 * @author Freddy Contreras <freddy.contreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
 * @version 31/05/2015
 */

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {
        $entityCard = 20000000;
        for ($i=0; $i < 3 ; $i++) { 
           
            $user = new User();
            $user->setIndentityCard($entityCard);
            $user->setUserName('user'.$i);
            $user->setName('user'.$i);
            $user->setEmail('user'.$i.'@facyt.uc.edu.ve');
            $user->setPassword('123456');
            $user->setPhone('0412-000000'.$i);
            $school = $manager->getRepository('DSFacytDomain:School')->findOneById(1);
            $user->setSchool($school);
            $user->addRole(1);
            $user->setEnabled(true);


            $manager->persist($user);
            $manager->flush();
        }
    }
    
    /**
    * Función que identifica el orden de ejecución de DataFixture
    * @return int
    */
    public function getOrder()
    {
        return 10;
    }
}