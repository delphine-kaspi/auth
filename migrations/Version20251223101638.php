<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251223101638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artiste (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, photo VARCHAR(255) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE representation (id INT AUTO_INCREMENT NOT NULL, date_representation DATE NOT NULL, heure_representation TIME NOT NULL, prix NUMERIC(6, 2) NOT NULL, salle_id INT NOT NULL, spectacle_id INT NOT NULL, INDEX IDX_29D5499EDC304035 (salle_id), INDEX IDX_29D5499EC682915D (spectacle_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, nb_place INT NOT NULL, date_resa DATETIME NOT NULL, user_id INT NOT NULL, representation_id INT NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C8495546CE82F4 (representation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, capacite INT NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal VARCHAR(10) NOT NULL, ville VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE spectacle (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, duree INT NOT NULL, artiste_id INT NOT NULL, INDEX IDX_E55076F421D25844 (artiste_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE representation ADD CONSTRAINT FK_29D5499EDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE representation ADD CONSTRAINT FK_29D5499EC682915D FOREIGN KEY (spectacle_id) REFERENCES spectacle (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495546CE82F4 FOREIGN KEY (representation_id) REFERENCES representation (id)');
        $this->addSql('ALTER TABLE spectacle ADD CONSTRAINT FK_E55076F421D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE representation DROP FOREIGN KEY FK_29D5499EDC304035');
        $this->addSql('ALTER TABLE representation DROP FOREIGN KEY FK_29D5499EC682915D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495546CE82F4');
        $this->addSql('ALTER TABLE spectacle DROP FOREIGN KEY FK_E55076F421D25844');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE representation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE spectacle');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
