<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425120316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licencie ADD idclub_id INT DEFAULT NULL, ADD qualite_id INT DEFAULT NULL, DROP idclub, DROP idqualite');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612BE1D585C FOREIGN KEY (idclub_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612A6338570 FOREIGN KEY (qualite_id) REFERENCES qualite (id)');
        $this->addSql('CREATE INDEX IDX_3B755612BE1D585C ON licencie (idclub_id)');
        $this->addSql('CREATE INDEX IDX_3B755612A6338570 ON licencie (qualite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612BE1D585C');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612A6338570');
        $this->addSql('DROP INDEX IDX_3B755612BE1D585C ON licencie');
        $this->addSql('DROP INDEX IDX_3B755612A6338570 ON licencie');
        $this->addSql('ALTER TABLE licencie ADD idclub VARCHAR(255) NOT NULL, ADD idqualite VARCHAR(255) NOT NULL, DROP idclub_id, DROP qualite_id');
    }
}
