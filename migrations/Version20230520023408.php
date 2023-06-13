<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520023408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dbara_reel (id INT AUTO_INCREMENT NOT NULL, chef_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, video VARCHAR(255) NOT NULL, INDEX IDX_84EA53D1150A48F1 (chef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dbara_reel ADD CONSTRAINT FK_84EA53D1150A48F1 FOREIGN KEY (chef_id) REFERENCES chef (id)');
        $this->addSql('ALTER TABLE chef CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE dbara_recette CHANGE photo photo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dbara_reel DROP FOREIGN KEY FK_84EA53D1150A48F1');
        $this->addSql('DROP TABLE dbara_reel');
        $this->addSql('ALTER TABLE chef CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE dbara_recette CHANGE photo photo VARCHAR(255) NOT NULL');
    }
}
