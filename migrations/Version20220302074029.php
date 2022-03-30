<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302074029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A743E4BEC');
        $this->addSql('ALTER TABLE pages DROP FOREIGN KEY FK_2074E575579F4768');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A401ADD27');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52ED823E37A');
        $this->addSql('ALTER TABLE pages DROP FOREIGN KEY FK_2074E575D823E37A');
        $this->addSql('CREATE TABLE lmpages (id INT AUTO_INCREMENT NOT NULL, story_id INT DEFAULT NULL, pages_numbers INT NOT NULL, INDEX IDX_8346F703AA5D4036 (story_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lms (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, numbers INT NOT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE luc (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, numbers INT NOT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lupages (id INT AUTO_INCREMENT NOT NULL, chapter_id INT DEFAULT NULL, pages_numbers INT NOT NULL, INDEX IDX_6CC377F5579F4768 (chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lmpages ADD CONSTRAINT FK_8346F703AA5D4036 FOREIGN KEY (story_id) REFERENCES lms (id)');
        $this->addSql('ALTER TABLE lupages ADD CONSTRAINT FK_6CC377F5579F4768 FOREIGN KEY (chapter_id) REFERENCES luc (id)');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE pages');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP INDEX IDX_E01FBE6A743E4BEC ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A401ADD27 ON images');
        $this->addSql('ALTER TABLE images ADD lmpages_id INT DEFAULT NULL, ADD lms_id INT DEFAULT NULL, ADD luc_id INT DEFAULT NULL, ADD lupages_id INT DEFAULT NULL, DROP pages_id, DROP chapter_cover_id, DROP is_valid');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AA045E835 FOREIGN KEY (lmpages_id) REFERENCES lmpages (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A4FDCCE2E FOREIGN KEY (lms_id) REFERENCES lms (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A4F5545F2 FOREIGN KEY (luc_id) REFERENCES luc (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB75D085C FOREIGN KEY (lupages_id) REFERENCES lupages (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AA045E835 ON images (lmpages_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A4FDCCE2E ON images (lms_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A4F5545F2 ON images (luc_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AB75D085C ON images (lupages_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AA045E835');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A4FDCCE2E');
        $this->addSql('ALTER TABLE lmpages DROP FOREIGN KEY FK_8346F703AA5D4036');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A4F5545F2');
        $this->addSql('ALTER TABLE lupages DROP FOREIGN KEY FK_6CC377F5579F4768');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB75D085C');
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, section_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, numbers INT NOT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F981B52ED823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, chapter_id INT DEFAULT NULL, pages_numbers INT NOT NULL, INDEX IDX_2074E575579F4768 (chapter_id), INDEX IDX_2074E575D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, section VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52ED823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E575579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E575D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('DROP TABLE lmpages');
        $this->addSql('DROP TABLE lms');
        $this->addSql('DROP TABLE luc');
        $this->addSql('DROP TABLE lupages');
        $this->addSql('DROP INDEX IDX_E01FBE6AA045E835 ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A4FDCCE2E ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A4F5545F2 ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6AB75D085C ON images');
        $this->addSql('ALTER TABLE images ADD pages_id INT DEFAULT NULL, ADD chapter_cover_id INT DEFAULT NULL, ADD is_valid TINYINT(1) NOT NULL, DROP lmpages_id, DROP lms_id, DROP luc_id, DROP lupages_id');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A401ADD27 FOREIGN KEY (pages_id) REFERENCES pages (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A743E4BEC FOREIGN KEY (chapter_cover_id) REFERENCES chapter (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A743E4BEC ON images (chapter_cover_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A401ADD27 ON images (pages_id)');
    }
}
