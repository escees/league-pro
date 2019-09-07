<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20190630120550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, football_match_id INT NOT NULL, minute INT NOT NULL, color VARCHAR(255) NOT NULL, INDEX IDX_161498D399E6F5DF (player_id), INDEX IDX_161498D3E1DA134D (football_match_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, appearances INT DEFAULT NULL, date_of_birth DATETIME DEFAULT NULL, INDEX IDX_98197A65296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, wins INT NOT NULL DEFAULT 0, wins_after_penalties INT NOT NULL DEFAULT 0, draws INT NOT NULL DEFAULT 0, loses INT NOT NULL DEFAULT 0, description VARCHAR(255) NOT NULL, crest LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', photo LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE football_match (id INT AUTO_INCREMENT NOT NULL, home_team_id INT NOT NULL, away_team_id INT NOT NULL, result VARCHAR(255) DEFAULT NULL, start_date DATETIME NOT NULL, description VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_7A5BC5059C4C13F6 (home_team_id), UNIQUE INDEX UNIQ_7A5BC50545185D02 (away_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goal (id INT AUTO_INCREMENT NOT NULL, assistant_id INT DEFAULT NULL, football_match_id INT NOT NULL, scorer_id INT NOT NULL, minute INT NOT NULL, UNIQUE INDEX UNIQ_FCDCEB2EE05387EF (assistant_id), INDEX IDX_FCDCEB2EE1DA134D (football_match_id), INDEX IDX_FCDCEB2E43B35028 (scorer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, photo LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', video VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D399E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3E1DA134D FOREIGN KEY (football_match_id) REFERENCES football_match (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_7A5BC5059C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_7A5BC50545185D02 FOREIGN KEY (away_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EE05387EF FOREIGN KEY (assistant_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EE1DA134D FOREIGN KEY (football_match_id) REFERENCES football_match (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E43B35028 FOREIGN KEY (scorer_id) REFERENCES player (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D399E6F5DF');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EE05387EF');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E43B35028');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65296CD8AE');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_7A5BC5059C4C13F6');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_7A5BC50545185D02');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3E1DA134D');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EE1DA134D');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE football_match');
        $this->addSql('DROP TABLE goal');
        $this->addSql('DROP TABLE news');
    }
}
