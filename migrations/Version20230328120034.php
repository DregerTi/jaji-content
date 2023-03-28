<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328120034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE contents_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contents (id INT NOT NULL, prewiew_img VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, src VARCHAR(255) DEFAULT NULL, id_author INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN contents.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN contents.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE contents_offers (contents_id INT NOT NULL, offers_id INT NOT NULL, PRIMARY KEY(contents_id, offers_id))');
        $this->addSql('CREATE INDEX IDX_52A44D0E394E8343 ON contents_offers (contents_id)');
        $this->addSql('CREATE INDEX IDX_52A44D0EA090B42E ON contents_offers (offers_id)');
        $this->addSql('CREATE TABLE offers (id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN offers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN offers.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE contents_offers ADD CONSTRAINT FK_52A44D0E394E8343 FOREIGN KEY (contents_id) REFERENCES contents (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents_offers ADD CONSTRAINT FK_52A44D0EA090B42E FOREIGN KEY (offers_id) REFERENCES offers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE contents_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offers_id_seq CASCADE');
        $this->addSql('ALTER TABLE contents_offers DROP CONSTRAINT FK_52A44D0E394E8343');
        $this->addSql('ALTER TABLE contents_offers DROP CONSTRAINT FK_52A44D0EA090B42E');
        $this->addSql('DROP TABLE contents');
        $this->addSql('DROP TABLE contents_offers');
        $this->addSql('DROP TABLE offers');
    }
}
