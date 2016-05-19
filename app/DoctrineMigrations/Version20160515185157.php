<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DSFacyt\Core\Domain\Model\ValueObject\Slug;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160515185157 extends AbstractMigration implements ContainerAwareInterface
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

        $channels = $manager->getRepository('DSFacytInfrastructureBundle:Channel')->findAll();

        foreach ($channels as $currentChannel) {

            $slug = new Slug($currentChannel->getName());
            $currentChannel->setSlug($slug->getSlug());
            $manager->persist($currentChannel);
        }

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

