<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210608102849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE match_details ADD mvp_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE match_details ADD CONSTRAINT FK_58054E5810514F6 FOREIGN KEY (mvp_id) REFERENCES man_of_the_match (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58054E5810514F6 ON match_details (mvp_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE match_details DROP FOREIGN KEY FK_58054E5810514F6');
        $this->addSql('DROP INDEX UNIQ_58054E5810514F6 ON match_details');
        $this->addSql('ALTER TABLE match_details DROP mvp_id');
    }
}
