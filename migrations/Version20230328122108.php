<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328122108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE favorites_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contents_categories (contents_id INT NOT NULL, categories_id INT NOT NULL, PRIMARY KEY(contents_id, categories_id))');
        $this->addSql('CREATE INDEX IDX_17A98AEF394E8343 ON contents_categories (contents_id)');
        $this->addSql('CREATE INDEX IDX_17A98AEFA21214B7 ON contents_categories (categories_id)');
        $this->addSql('CREATE TABLE favorites (id INT NOT NULL, liker_id INT NOT NULL, content_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E46960F5979F103A ON favorites (liker_id)');
        $this->addSql('CREATE INDEX IDX_E46960F584A0A3ED ON favorites (content_id)');
        $this->addSql('ALTER TABLE contents_categories ADD CONSTRAINT FK_17A98AEF394E8343 FOREIGN KEY (contents_id) REFERENCES contents (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents_categories ADD CONSTRAINT FK_17A98AEFA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5979F103A FOREIGN KEY (liker_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F584A0A3ED FOREIGN KEY (content_id) REFERENCES contents (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contents ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contents DROP id_author');
        $this->addSql('ALTER TABLE contents ALTER prewiew_img SET NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER title SET NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER type SET NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER content SET NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE contents ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE contents ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER updated_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE contents ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE contents ALTER updated_at SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN contents.created_at IS NULL');
        $this->addSql('COMMENT ON COLUMN contents.updated_at IS NULL');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA1177B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA1177896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B4FA1177B03A8386 ON contents (created_by_id)');
        $this->addSql('CREATE INDEX IDX_B4FA1177896DBBDE ON contents (updated_by_id)');
        $this->addSql('ALTER TABLE offers ALTER title SET NOT NULL');
        $this->addSql('ALTER TABLE offers ALTER link SET NOT NULL');
        $this->addSql('ALTER TABLE offers ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE offers ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE offers ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE offers ALTER updated_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE offers ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE offers ALTER updated_at SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN offers.created_at IS NULL');
        $this->addSql('COMMENT ON COLUMN offers.updated_at IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE favorites_id_seq CASCADE');
        $this->addSql('ALTER TABLE contents_categories DROP CONSTRAINT FK_17A98AEF394E8343');
        $this->addSql('ALTER TABLE contents_categories DROP CONSTRAINT FK_17A98AEFA21214B7');
        $this->addSql('ALTER TABLE favorites DROP CONSTRAINT FK_E46960F5979F103A');
        $this->addSql('ALTER TABLE favorites DROP CONSTRAINT FK_E46960F584A0A3ED');
        $this->addSql('DROP TABLE contents_categories');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('ALTER TABLE contents DROP CONSTRAINT FK_B4FA1177B03A8386');
        $this->addSql('ALTER TABLE contents DROP CONSTRAINT FK_B4FA1177896DBBDE');
        $this->addSql('DROP INDEX IDX_B4FA1177B03A8386');
        $this->addSql('DROP INDEX IDX_B4FA1177896DBBDE');
        $this->addSql('ALTER TABLE contents ADD id_author INT NOT NULL');
        $this->addSql('ALTER TABLE contents DROP created_by_id');
        $this->addSql('ALTER TABLE contents DROP updated_by_id');
        $this->addSql('ALTER TABLE contents ALTER prewiew_img DROP NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER title DROP NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER type DROP NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER content DROP NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE contents ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE contents ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE contents ALTER updated_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE contents ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE contents ALTER updated_at DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN contents.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN contents.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE offers ALTER title DROP NOT NULL');
        $this->addSql('ALTER TABLE offers ALTER link DROP NOT NULL');
        $this->addSql('ALTER TABLE offers ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE offers ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE offers ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE offers ALTER updated_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE offers ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE offers ALTER updated_at DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN offers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN offers.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }
}
