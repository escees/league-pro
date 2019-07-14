<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190714110118 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE football_match DROP INDEX UNIQ_8CE33ACE9C4C13F6, ADD INDEX IDX_8CE33ACE9C4C13F6 (home_team_id)');
        $this->addSql('ALTER TABLE football_match DROP INDEX UNIQ_8CE33ACE45185D02, ADD INDEX IDX_8CE33ACE45185D02 (away_team_id)');
        $this->addSql('ALTER TABLE football_match CHANGE away_team_id away_team_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE football_match DROP INDEX IDX_8CE33ACE9C4C13F6, ADD UNIQUE INDEX UNIQ_8CE33ACE9C4C13F6 (home_team_id)');
        $this->addSql('ALTER TABLE football_match DROP INDEX IDX_8CE33ACE45185D02, ADD UNIQUE INDEX UNIQ_8CE33ACE45185D02 (away_team_id)');
        $this->addSql('ALTER TABLE football_match CHANGE away_team_id away_team_id INT NOT NULL');
    }
}
