<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427002943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription_atelier (inscription_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_C86AEECF5DAC5993 (inscription_id), INDEX IDX_C86AEECF82E2CF35 (atelier_id), PRIMARY KEY(inscription_id, atelier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription_atelier ADD CONSTRAINT FK_C86AEECF5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_atelier ADD CONSTRAINT FK_C86AEECF82E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE atelier_inscription DROP FOREIGN KEY FK_20EC8DC85DAC5993');
        $this->addSql('ALTER TABLE atelier_inscription DROP FOREIGN KEY FK_20EC8DC882E2CF35');
        $this->addSql('DROP TABLE atelier_inscription');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier_inscription (atelier_id INT NOT NULL, inscription_id INT NOT NULL, INDEX IDX_20EC8DC882E2CF35 (atelier_id), INDEX IDX_20EC8DC85DAC5993 (inscription_id), PRIMARY KEY(atelier_id, inscription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE atelier_inscription ADD CONSTRAINT FK_20EC8DC85DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE atelier_inscription ADD CONSTRAINT FK_20EC8DC882E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_atelier DROP FOREIGN KEY FK_C86AEECF5DAC5993');
        $this->addSql('ALTER TABLE inscription_atelier DROP FOREIGN KEY FK_C86AEECF82E2CF35');
        $this->addSql('DROP TABLE inscription_atelier');
    }
}
