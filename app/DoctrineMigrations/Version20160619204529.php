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

        $newGroup = new Group();
        $newGroup->setName('Profesor');

        $manager->persist($newGroup);

        $newGroup2 = new Group();
        $newGroup2->setName('Estudiante');

        $manager->persist($newGroup2);

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
