<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190818112710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, league_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F0E45BA958AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA958AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F58AFC4DE');
        $this->addSql('DROP INDEX IDX_C4E0A61F58AFC4DE ON team');
        $this->addSql('ALTER TABLE team DROP league_id');
        $this->addSql('ALTER TABLE team ADD season_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F4EC001D1 ON team (season_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F4EC001D1');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP INDEX IDX_C4E0A61F4EC001D1 ON team');
        $this->addSql('ALTER TABLE team ADD league_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team DROP season_id');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F58AFC4DE ON team (league_id)');
    }
}
