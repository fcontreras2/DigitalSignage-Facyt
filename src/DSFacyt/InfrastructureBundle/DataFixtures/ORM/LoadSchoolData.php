<?php
namespace DSFacyt\InfrastructureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DSFacyt\Core\Domain\Model\Entity\School;

/**
 * Clase LoadSchoolData "DataFixtures".
 *
 * La clase carga los datos de prueba del sistema de las escuelas o carreras a las que estan
 * asociadas los usuarios del sistema.
 *
 * @author Freddy Contreras <freddy.contreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
 * @version 31/05/2015
 */

class LoadSchoolData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {
        $school = new School();
        $school->setName('Computación');
        $school->setDescription('Descripción Computación');

        $manager->persist($school);
        $manager->flush();

        $school = new School();
        $school->setName('Química');
        $school->setDescription('Descripción Química');

        $manager->persist($school);
        $manager->flush();
    }
    
    /**
    * Función que identifica el orden de ejecución de DataFixture
    * @return int
    */
    public function getOrder()
    {
        return 1;
    }
}