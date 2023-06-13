<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517214921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chef (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, numerotelephone VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dbara_recette (id INT AUTO_INCREMENT NOT NULL, chef_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, preparation VARCHAR(255) NOT NULL, tempspreparation VARCHAR(255) NOT NULL, ingredients VARCHAR(255) NOT NULL, nombreingredients VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, temperature VARCHAR(255) NOT NULL, INDEX IDX_7578D0E3150A48F1 (chef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dbara_recette ADD CONSTRAINT FK_7578D0E3150A48F1 FOREIGN KEY (chef_id) REFERENCES chef (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dbara_recette DROP FOREIGN KEY FK_7578D0E3150A48F1');
        $this->addSql('DROP TABLE chef');
        $this->addSql('DROP TABLE dbara_recette');
    }
}
