<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160619204523 extends AbstractMigration
{
        /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE group_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE group_user (id INT NOT NULL, name VARCHAR(255) NOT NULL, defaults_permisions TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN group_user.defaults_permisions IS \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE fos_user ADD group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user ADD access TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A6479FE54D947 FOREIGN KEY (group_id) REFERENCES group_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_957A6479FE54D947 ON fos_user (group_id)');
        $this->addSql('COMMENT ON COLUMN fos_user.access IS \'(DC2Type:json_array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE fos_user DROP CONSTRAINT FK_957A6479FE54D947');
        $this->addSql('DROP SEQUENCE group_user_id_seq CASCADE');
        $this->addSql('DROP TABLE group_user');
        $this->addSql('DROP INDEX IDX_957A6479FE54D947');
        $this->addSql('ALTER TABLE fos_user DROP group_id');
        $this->addSql('ALTER TABLE fos_user DROP access');
    }
}
