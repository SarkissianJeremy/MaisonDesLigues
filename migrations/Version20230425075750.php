<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425075750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vacation (id INT AUTO_INCREMENT NOT NULL, atelier_id INT DEFAULT NULL, dateheure_debut DATE NOT NULL, dateheure_fin DATE NOT NULL, INDEX IDX_E3DADF7582E2CF35 (atelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vacation ADD CONSTRAINT FK_E3DADF7582E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE club CHANGE ID id INT AUTO_INCREMENT NOT NULL, CHANGE NOM nom VARCHAR(70) NOT NULL, CHANGE ADRESSE1 adresse1 VARCHAR(60) NOT NULL, CHANGE CP cp INT NOT NULL, CHANGE VILLE ville VARCHAR(70) NOT NULL, CHANGE TEL tel INT NOT NULL');
        $this->addSql('ALTER TABLE licencie CHANGE ID id INT AUTO_INCREMENT NOT NULL, CHANGE NUMLICENCE numlicence INT NOT NULL, CHANGE NOM nom VARCHAR(70) NOT NULL, CHANGE PRENOM prenom VARCHAR(70) NOT NULL, CHANGE ADRESSE1 adresse1 VARCHAR(255) NOT NULL, CHANGE CP cp INT NOT NULL, CHANGE VILLE ville VARCHAR(255) NOT NULL, CHANGE TEL tel INT NOT NULL, CHANGE MAIL mail VARCHAR(100) NOT NULL, CHANGE DATEADHESION dateadhesion DATE NOT NULL, CHANGE IDCLUB idclub VARCHAR(255) NOT NULL, CHANGE IDQUALITE idqualite VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE qualite CHANGE ID id INT AUTO_INCREMENT NOT NULL, CHANGE LIBELLEQUALITE libellequalite VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacation DROP FOREIGN KEY FK_E3DADF7582E2CF35');
        $this->addSql('DROP TABLE vacation');
        $this->addSql('ALTER TABLE licencie CHANGE id ID INT NOT NULL, CHANGE nom NOM VARCHAR(70) DEFAULT NULL, CHANGE prenom PRENOM VARCHAR(70) DEFAULT NULL, CHANGE adresse1 ADRESSE1 VARCHAR(255) DEFAULT NULL, CHANGE cp CP CHAR(6) DEFAULT NULL, CHANGE ville VILLE VARCHAR(70) DEFAULT NULL, CHANGE tel TEL CHAR(14) DEFAULT NULL, CHANGE mail MAIL VARCHAR(100) DEFAULT NULL, CHANGE dateadhesion DATEADHESION DATE DEFAULT NULL, CHANGE idclub IDCLUB INT DEFAULT NULL, CHANGE idqualite IDQUALITE INT DEFAULT NULL, CHANGE numlicence NUMLICENCE INT DEFAULT NULL');
        $this->addSql('ALTER TABLE qualite CHANGE id ID INT NOT NULL, CHANGE libellequalite LIBELLEQUALITE VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE club CHANGE id ID INT NOT NULL, CHANGE nom NOM VARCHAR(50) DEFAULT NULL, CHANGE adresse1 ADRESSE1 VARCHAR(60) DEFAULT NULL, CHANGE cp CP CHAR(5) DEFAULT NULL, CHANGE ville VILLE VARCHAR(60) DEFAULT NULL, CHANGE tel TEL CHAR(14) DEFAULT NULL');
    }
}
