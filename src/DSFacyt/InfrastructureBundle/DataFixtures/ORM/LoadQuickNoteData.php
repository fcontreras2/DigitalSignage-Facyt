<?php
namespace Navicu\InfrastructureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DSFacty\Core\Domain\Model\Entity\QuickNote;

/**
 * Clase LoadQuickNoteData "DataFixtures".
 *
 * La clase carga los datos de prueba del sistema de las notas rápidas
 *
 * @author Freddy Contreras <freddy.contreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
 * @version 31/05/2015
 */

class LoadQuickNoteData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {
    
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