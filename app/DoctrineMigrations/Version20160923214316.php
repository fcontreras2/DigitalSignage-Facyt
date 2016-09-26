<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160923214316 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE text ADD active BOOLEAN DEFAULT \'true\' NOT NULL');
        $this->addSql('ALTER TABLE video ADD active BOOLEAN DEFAULT \'true\' NOT NULL');
        $this->addSql('ALTER TABLE image ADD active BOOLEAN DEFAULT \'true\' NOT NULL');
        $this->addSql('ALTER TABLE fos_user ALTER username TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE fos_user ALTER username_canonical TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE fos_user ALTER email TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE fos_user ALTER email_canonical TYPE VARCHAR(180)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE text DROP active');
        $this->addSql('ALTER TABLE video DROP active');
        $this->addSql('ALTER TABLE image DROP active');
        $this->addSql('ALTER TABLE fos_user ALTER username TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE fos_user ALTER username_canonical TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE fos_user ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE fos_user ALTER email_canonical TYPE VARCHAR(255)');
    }
}
