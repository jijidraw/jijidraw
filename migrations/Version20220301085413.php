<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301085413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, section_id INT NOT NULL, name VARCHAR(255) NOT NULL, numbers INT NOT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_F981B52ED823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, pages_id INT DEFAULT NULL, portfolio_id INT DEFAULT NULL, chapter_cover_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A401ADD27 (pages_id), INDEX IDX_E01FBE6AB96B5643 (portfolio_id), INDEX IDX_E01FBE6A743E4BEC (chapter_cover_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, chapter_id INT DEFAULT NULL, pages_numbers INT NOT NULL, INDEX IDX_2074E575D823E37A (section_id), INDEX IDX_2074E575579F4768 (chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, section VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52ED823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A401ADD27 FOREIGN KEY (pages_id) REFERENCES pages (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A743E4BEC FOREIGN KEY (chapter_cover_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E575D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E575579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A743E4BEC');
        $this->addSql('ALTER TABLE pages DROP FOREIGN KEY FK_2074E575579F4768');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A401ADD27');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB96B5643');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52ED823E37A');
        $this->addSql('ALTER TABLE pages DROP FOREIGN KEY FK_2074E575D823E37A');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE pages');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE section');
    }
}
