<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210921202156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE football_match_team (football_match_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_6CE421C5E1DA134D (football_match_id), INDEX IDX_6CE421C5296CD8AE (team_id), PRIMARY KEY(football_match_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE football_match_team ADD CONSTRAINT FK_6CE421C5E1DA134D FOREIGN KEY (football_match_id) REFERENCES football_match (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE football_match_team ADD CONSTRAINT FK_6CE421C5296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE football_match ADD winner_id INT DEFAULT NULL, ADD loser_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACE5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACE1BCAA5F6 FOREIGN KEY (loser_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_8CE33ACE5DFCD4B8 ON football_match (winner_id)');
        $this->addSql('CREATE INDEX IDX_8CE33ACE1BCAA5F6 ON football_match (loser_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE football_match_team');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACE5DFCD4B8');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACE1BCAA5F6');
        $this->addSql('DROP INDEX IDX_8CE33ACE5DFCD4B8 ON football_match');
        $this->addSql('DROP INDEX IDX_8CE33ACE1BCAA5F6 ON football_match');
        $this->addSql('ALTER TABLE football_match DROP winner_id, DROP loser_id');
    }
}
