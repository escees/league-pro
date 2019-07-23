<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190722150354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3BF396750');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EBF396750');
        $this->addSql('DROP TABLE match_event');
        $this->addSql('ALTER TABLE card ADD player_id INT NOT NULL, ADD match_details_id INT NOT NULL, ADD minute INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D399E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3FA07CC0E FOREIGN KEY (match_details_id) REFERENCES match_details (id)');
        $this->addSql('CREATE INDEX IDX_161498D399E6F5DF ON card (player_id)');
        $this->addSql('CREATE INDEX IDX_161498D3FA07CC0E ON card (match_details_id)');
        $this->addSql('ALTER TABLE goal ADD scorer_id INT NOT NULL, ADD match_details_id INT NOT NULL, ADD minute INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E43B35028 FOREIGN KEY (scorer_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EFA07CC0E FOREIGN KEY (match_details_id) REFERENCES match_details (id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E43B35028 ON goal (scorer_id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2EFA07CC0E ON goal (match_details_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE match_event (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, match_details_id INT NOT NULL, minute INT NOT NULL, discr VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_85C47506FA07CC0E (match_details_id), INDEX IDX_85C4750699E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE match_event ADD CONSTRAINT FK_85C4750699E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE match_event ADD CONSTRAINT FK_85C47506FA07CC0E FOREIGN KEY (match_details_id) REFERENCES match_details (id)');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D399E6F5DF');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3FA07CC0E');
        $this->addSql('DROP INDEX IDX_161498D399E6F5DF ON card');
        $this->addSql('DROP INDEX IDX_161498D3FA07CC0E ON card');
        $this->addSql('ALTER TABLE card DROP player_id, DROP match_details_id, DROP minute, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3BF396750 FOREIGN KEY (id) REFERENCES match_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E43B35028');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EFA07CC0E');
        $this->addSql('DROP INDEX IDX_FCDCEB2E43B35028 ON goal');
        $this->addSql('DROP INDEX IDX_FCDCEB2EFA07CC0E ON goal');
        $this->addSql('ALTER TABLE goal DROP scorer_id, DROP match_details_id, DROP minute, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EBF396750 FOREIGN KEY (id) REFERENCES match_event (id) ON DELETE CASCADE');
    }
}
