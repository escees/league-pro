<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190803111905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player ADD number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team CHANGE wins wins INT NOT NULL, CHANGE wins_after_penalties wins_after_penalties INT NOT NULL, CHANGE draws draws INT NOT NULL, CHANGE loses loses INT NOT NULL, CHANGE points points INT NOT NULL, CHANGE goals_scored goals_scored INT NOT NULL, CHANGE goals_conceded goals_conceded INT NOT NULL, CHANGE loses_after_penalties loses_after_penalties INT NOT NULL');
        $this->addSql('ALTER TABLE match_details CHANGE home_team_penalties home_team_penalties INT DEFAULT NULL, CHANGE away_team_penalties away_team_penalties INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE match_details CHANGE home_team_penalties home_team_penalties INT DEFAULT 0, CHANGE away_team_penalties away_team_penalties INT DEFAULT 0');
        $this->addSql('ALTER TABLE player DROP number');
        $this->addSql('ALTER TABLE team CHANGE wins wins INT DEFAULT 0 NOT NULL, CHANGE wins_after_penalties wins_after_penalties INT DEFAULT 0 NOT NULL, CHANGE draws draws INT DEFAULT 0 NOT NULL, CHANGE loses loses INT DEFAULT 0 NOT NULL, CHANGE points points INT DEFAULT 0 NOT NULL, CHANGE goals_scored goals_scored INT DEFAULT 0 NOT NULL, CHANGE goals_conceded goals_conceded INT DEFAULT 0 NOT NULL, CHANGE loses_after_penalties loses_after_penalties INT DEFAULT 0');
    }
}
