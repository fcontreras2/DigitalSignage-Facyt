<?php
namespace Navicu\InfrastructureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DSFacyt\Core\Domain\Model\Entity\Text;

/**
 * Clase LoadTextData "DataFixtures".
 *
 * La clase carga los datos de prueba del sistema de las textos
 *
 * @author Freddy Contreras <freddy.contreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
 * @version 31/05/2015
 */

class LoadTextData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 12 ; $i++) { 
        
            $text = new Text();
            $text->setStartDate(new \DateTime());
            $text->setEndDate(new \DateTime());
            $text->setTitle('image_title'.$i);
            $text->setInfo('image_description'.$i);
            $text->setPublishTime(new \DateTime());
            $text->setStatus('ACTIVE');

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

            $text->setUser($user);
            $text->addChannel($channel);

            $manager->persist($text);
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