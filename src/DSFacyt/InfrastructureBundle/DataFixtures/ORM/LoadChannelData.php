<?php
namespace DSFacyt\InfrastructureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DSFacyt\InfrastructureBundle\Entity\Channel;

/**
 * Clase LoadChannelData "DataFixtures".
 *
 * La clase carga los datos de prueba del sistema de los canales donde se publicara la información
 *
 * @author Freddy Contreras <freddy.contreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
 * @version 31/05/2015
 */

class LoadChannelData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 3; $i++) { 
            $channel = new Channel();
            $channel->setName('channel'.$i);
            $channel->setDescription('Description'.$i);
            $channel->setStatus('ACTIVE');

            $manager->persist($channel);
            $manager->flush();
        }        
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