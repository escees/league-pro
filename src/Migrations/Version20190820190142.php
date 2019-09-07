<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190820190142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE match_day (id INT AUTO_INCREMENT NOT NULL, season_id INT NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_E1EE884E4EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE match_day ADD CONSTRAINT FK_E1EE884E4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE football_match ADD match_day_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACEA8ADB827 FOREIGN KEY (match_day_id) REFERENCES match_day (id)');
        $this->addSql('CREATE INDEX IDX_8CE33ACEA8ADB827 ON football_match (match_day_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACEA8ADB827');
        $this->addSql('DROP TABLE match_day');
        $this->addSql('DROP INDEX IDX_8CE33ACEA8ADB827 ON football_match');
        $this->addSql('ALTER TABLE football_match DROP match_day_id');
    }
}
