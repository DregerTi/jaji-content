<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329081512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contents_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE favorites_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contents (id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, prewiew_img VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, src VARCHAR(350) DEFAULT NULL, content TEXT NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B4FA1177B03A8386 ON contents (created_by_id)');
        $this->addSql('CREATE INDEX IDX_B4FA1177896DBBDE ON contents (updated_by_id)');
        $this->addSql('CREATE TABLE contents_offers (contents_id INT NOT NULL, offers_id INT NOT NULL, PRIMARY KEY(contents_id, offers_id))');
        $this->addSql('CREATE INDEX IDX_52A44D0E394E8343 ON contents_offers (contents_id)');
        $this->addSql('CREATE INDEX IDX_52A44D0EA090B42E ON contents_offers (offers_id)');
        $this->addSql('CREATE TABLE contents_categories (contents_id INT NOT NULL, categories_id INT NOT NULL, PRIMARY KEY(contents_id, categories_id))');
        $this->addSql('CREATE INDEX IDX_17A98AEF394E8343 ON contents_categories (contents_id)');
        $this->addSql('CREATE INDEX IDX_17A98AEFA21214B7 ON contents_categories (categories_id)');
        $this->addSql('CREATE TABLE favorites (id INT NOT NULL, liker_id INT NOT NULL, content_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E46960F5979F103A ON favorites (liker_id)');
        $this->addSql('CREATE INDEX IDX_E46960F584A0A3ED ON favorites (content_id)');
        $this->addSql('CREATE TABLE offers (id INT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(80) NOT NULL, lastname VARCHAR(80) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE TABLE users_categories (users_id INT NOT NULL, categories_id INT NOT NULL, PRIMARY KEY(users_id, categories_id))');
        $this->addSql('CREATE INDEX IDX_ED98E9FC67B3B43D ON users_categories (users_id)');
        $this->addSql('CREATE INDEX IDX_ED98E9FCA21214B7 ON users_categories (categories_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA1177B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA1177896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents_offers ADD CONSTRAINT FK_52A44D0E394E8343 FOREIGN KEY (contents_id) REFERENCES contents (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents_offers ADD CONSTRAINT FK_52A44D0EA090B42E FOREIGN KEY (offers_id) REFERENCES offers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents_categories ADD CONSTRAINT FK_17A98AEF394E8343 FOREIGN KEY (contents_id) REFERENCES contents (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents_categories ADD CONSTRAINT FK_17A98AEFA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5979F103A FOREIGN KEY (liker_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F584A0A3ED FOREIGN KEY (content_id) REFERENCES contents (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_categories ADD CONSTRAINT FK_ED98E9FC67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_categories ADD CONSTRAINT FK_ED98E9FCA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contents_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE favorites_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offers_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE contents DROP CONSTRAINT FK_B4FA1177B03A8386');
        $this->addSql('ALTER TABLE contents DROP CONSTRAINT FK_B4FA1177896DBBDE');
        $this->addSql('ALTER TABLE contents_offers DROP CONSTRAINT FK_52A44D0E394E8343');
        $this->addSql('ALTER TABLE contents_offers DROP CONSTRAINT FK_52A44D0EA090B42E');
        $this->addSql('ALTER TABLE contents_categories DROP CONSTRAINT FK_17A98AEF394E8343');
        $this->addSql('ALTER TABLE contents_categories DROP CONSTRAINT FK_17A98AEFA21214B7');
        $this->addSql('ALTER TABLE favorites DROP CONSTRAINT FK_E46960F5979F103A');
        $this->addSql('ALTER TABLE favorites DROP CONSTRAINT FK_E46960F584A0A3ED');
        $this->addSql('ALTER TABLE users_categories DROP CONSTRAINT FK_ED98E9FC67B3B43D');
        $this->addSql('ALTER TABLE users_categories DROP CONSTRAINT FK_ED98E9FCA21214B7');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE contents');
        $this->addSql('DROP TABLE contents_offers');
        $this->addSql('DROP TABLE contents_categories');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE offers');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_categories');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
