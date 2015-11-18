<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DSFacyt\Core\Domain\Model\Entity\School;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151117214555 extends AbstractMigration implements ContainerAwareInterface
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

        $school = new School();
        $school->setName('Física');
        $school->setDescription('Descripción Física');

        $manager->persist($school);
        $manager->flush();

        $school = new School();
        $school->setName('Matemática');
        $school->setDescription('Descripción Matemática');

        $manager->persist($school);
        $manager->flush();

        $school = new School();
        $school->setName('Biología');
        $school->setDescription('Descripción Biología');

        $manager->persist($school);
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
