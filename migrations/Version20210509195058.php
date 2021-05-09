<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210509195058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Agences (id INT AUTO_INCREMENT NOT NULL, nom TINYTEXT NOT NULL, tel_agence LONGTEXT NOT NULL, address_ville TINYTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Voitures (id INT AUTO_INCREMENT NOT NULL, agence_id INT NOT NULL, marque LONGTEXT NOT NULL, coleur LONGTEXT NOT NULL, description LONGTEXT NOT NULL, nombre_de_place INT NOT NULL, INDEX IDX_722E524DD725330D (agence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Voitures ADD CONSTRAINT FK_722E524DD725330D FOREIGN KEY (agence_id) REFERENCES Agences (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Voitures DROP FOREIGN KEY FK_722E524DD725330D');
        $this->addSql('DROP TABLE Agences');
        $this->addSql('DROP TABLE Voitures');
        $this->addSql('DROP TABLE `users`');
    }
}
