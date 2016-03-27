<?php
namespace Navicu\InfrastructureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DSFacyt\InfrastructureBundle\Entity\QuickNote;

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
        for ($i=0; $i < 12 ; $i++) { 
        
            $quickNote = new QuickNote();
            $quickNote->setStartDate(new \DateTime());
            $quickNote->setEndDate(new \DateTime());
            $quickNote->setTitle('image_title'.$i);
            $quickNote->setInfo('image_description'.$i);
            $quickNote->setStatus('ACTIVE');

            if ( $i < 4) {
                $user = $manager->getRepository("DSFacytDomain:User")
                    ->findOneById(1);
                $channel = $manager->getRepository("DSFacytDomain:Channel")
                    ->findOneById(1);
                    
            } else if ( $i < 8) {
                $user = $manager->getRepository("DSFacytDomain:User")
                    ->findOneById(2);                
                $channel = $manager->getRepository("DSFacytDomain:Channel")
                    ->findOneById(2);
            } else if ( $i < 12) {
                $user = $manager->getRepository("DSFacytDomain:User")
                    ->findOneById(3);
                $channel = $manager->getRepository("DSFacytDomain:Channel")
                    ->findOneById(3);                
            }

            $quickNote->setUser($user);
            $quickNote->addChannel($channel);

            $manager->persist($quickNote);
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