<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160626141604 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE notification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE notification (id INT NOT NULL, last_modified TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, view BOOLEAN DEFAULT \'false\' NOT NULL, publish_type VARCHAR(255) NOT NULL, publish_id INT NOT NULL, data TEXT NOT NULL, event VARCHAR(255) DEFAULT \'\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN notification.data IS \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE text ADD last_modified TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD last_modified TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD last_modified TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE notification_id_seq CASCADE');
        $this->addSql('DROP TABLE notification');
        $this->addSql('ALTER TABLE text DROP last_modified');
        $this->addSql('ALTER TABLE video DROP last_modified');
        $this->addSql('ALTER TABLE image DROP last_modified');
    }
}
