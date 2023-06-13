<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524184952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dbara_live (id INT AUTO_INCREMENT NOT NULL, chef_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, video VARCHAR(255) NOT NULL, invite VARCHAR(255) NOT NULL, INDEX IDX_2505732F150A48F1 (chef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dbara_live ADD CONSTRAINT FK_2505732F150A48F1 FOREIGN KEY (chef_id) REFERENCES chef (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dbara_live DROP FOREIGN KEY FK_2505732F150A48F1');
        $this->addSql('DROP TABLE dbara_live');
    }
}
