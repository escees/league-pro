<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190723183635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE goal CHANGE match_details_id match_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE card CHANGE match_details_id match_details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE football_match CHANGE start_date start_date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE football_match CHANGE start_date start_date DATE NOT NULL');
        $this->addSql('ALTER TABLE goal CHANGE match_details_id match_details_id INT NOT NULL');
//        $this->addSql('ALTER TABLE card CHANGE match_details_id match_details_id INT NOT NULL');
    }
}
