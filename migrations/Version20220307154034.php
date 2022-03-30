<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307154034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characters (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, height VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monsters (id INT AUTO_INCREMENT NOT NULL, story_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, height VARCHAR(255) NOT NULL, INDEX IDX_A1FAA7C8AA5D4036 (story_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE monsters ADD CONSTRAINT FK_A1FAA7C8AA5D4036 FOREIGN KEY (story_id) REFERENCES lms (id)');
        $this->addSql('ALTER TABLE images ADD monsters_id INT DEFAULT NULL, ADD characters_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A45D33345 FOREIGN KEY (monsters_id) REFERENCES monsters (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AC70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A45D33345 ON images (monsters_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AC70F0E28 ON images (characters_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AC70F0E28');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A45D33345');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE monsters');
        $this->addSql('DROP INDEX IDX_E01FBE6A45D33345 ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6AC70F0E28 ON images');
        $this->addSql('ALTER TABLE images DROP monsters_id, DROP characters_id');
    }
}
