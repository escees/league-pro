<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190727092344 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE goal ADD assistant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EE05387EF FOREIGN KEY (assistant_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2EE05387EF ON goal (assistant_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EE05387EF');
        $this->addSql('DROP INDEX IDX_FCDCEB2EE05387EF ON goal');
        $this->addSql('ALTER TABLE goal DROP assistant_id');
    }
}
