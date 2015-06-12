<?php
namespace Navicu\InfrastructureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DSFacyt\Core\Domain\Model\Entity\Video;

/**
 * Clase LoadVideoData "DataFixtures".
 *
 * La clase carga los datos de prueba del sistema de los videos
 *
 * @author Freddy Contreras <freddy.contreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
 * @version 31/05/2015
 */

class LoadVideoData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 12 ; $i++) { 
        
            $video = new Video();
            $video->setStartDate(new \DateTime());
            $video->setEndDate(new \DateTime());
            $video->setPublishTime(new \DateTime());
            $video->setTitle('image_title'.$i);
            $video->setDescription('image_description'.$i);
            $video->setStatus('ACTIVE');

            $document = $manager->getRepository("DSFacytDomain:Document")
                ->findOneById($i+1);

            $video->setDocument($document);

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

            $video->setUser($user);
            $video->addChannel($channel);

            $manager->persist($video);
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