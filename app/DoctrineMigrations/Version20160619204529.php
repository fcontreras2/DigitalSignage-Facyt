<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DSFacyt\InfrastructureBundle\Entity\Group;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160619204529 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
   /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $manager = $this->container->get('doctrine.orm.entity_manager');
        $access = ['text', 'image'];

        $newGroup = new Group();
        $newGroup->setName('Estudiante');
        $newGroup->setDefaultsPermisions($access);
        $manager->persist($newGroup);

        $access[] = 'video';
        $newGroup = new Group();
        $newGroup->setName('Profesor');
        $newGroup->setDefaultsPermisions($access);
        $manager->persist($newGroup);

        $manager->flush();

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
