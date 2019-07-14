<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190713210223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE match_event (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, match_details_id INT NOT NULL, minute INT NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_85C4750699E6F5DF (player_id), INDEX IDX_85C47506FA07CC0E (match_details_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE match_details (id INT AUTO_INCREMENT NOT NULL, home_team_goals INT NOT NULL, away_team_goals INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE match_event ADD CONSTRAINT FK_85C4750699E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE match_event ADD CONSTRAINT FK_85C47506FA07CC0E FOREIGN KEY (match_details_id) REFERENCES match_details (id)');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D399E6F5DF');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3E1DA134D');
        $this->addSql('DROP INDEX IDX_161498D399E6F5DF ON card');
        $this->addSql('DROP INDEX IDX_161498D3E1DA134D ON card');
        $this->addSql('ALTER TABLE card DROP player_id, DROP football_match_id, DROP minute, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3BF396750 FOREIGN KEY (id) REFERENCES match_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E43B35028');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EE1DA134D');
        $this->addSql('DROP INDEX IDX_FCDCEB2EE1DA134D ON goal');
        $this->addSql('DROP INDEX IDX_FCDCEB2E43B35028 ON goal');
        $this->addSql('ALTER TABLE goal DROP football_match_id, DROP scorer_id, DROP minute, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EBF396750 FOREIGN KEY (id) REFERENCES match_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE football_match ADD match_details_id INT DEFAULT NULL, DROP result');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACEFA07CC0E FOREIGN KEY (match_details_id) REFERENCES match_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8CE33ACEFA07CC0E ON football_match (match_details_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3BF396750');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EBF396750');
        $this->addSql('ALTER TABLE match_event DROP FOREIGN KEY FK_85C47506FA07CC0E');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACEFA07CC0E');
        $this->addSql('DROP TABLE match_event');
        $this->addSql('DROP TABLE match_details');
        $this->addSql('ALTER TABLE card ADD player_id INT NOT NULL, ADD football_match_id INT NOT NULL, ADD minute INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D399E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3E1DA134D FOREIGN KEY (football_match_id) REFERENCES football_match (id)');
        $this->addSql('CREATE INDEX IDX_161498D399E6F5DF ON card (player_id)');
        $this->addSql('CREATE INDEX IDX_161498D3E1DA134D ON card (football_match_id)');
        $this->addSql('DROP INDEX UNIQ_8CE33ACEFA07CC0E ON football_match');
        $this->addSql('ALTER TABLE football_match ADD result VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP match_details_id');
        $this->addSql('ALTER TABLE goal ADD football_match_id INT NOT NULL, ADD scorer_id INT NOT NULL, ADD minute INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E43B35028 FOREIGN KEY (scorer_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EE1DA134D FOREIGN KEY (football_match_id) REFERENCES football_match (id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2EE1DA134D ON goal (football_match_id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E43B35028 ON goal (scorer_id)');
    }
}
