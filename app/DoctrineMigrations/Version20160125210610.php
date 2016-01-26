<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160125210610 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE text DROP status');
        $this->addSql('ALTER TABLE quick_note DROP status');
        $this->addSql('ALTER TABLE video DROP status');
        $this->addSql('ALTER TABLE image DROP status');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE video ADD status INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE text ADD status INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE quick_note ADD status INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE image ADD status INT DEFAULT 0 NOT NULL');
    }
}
