<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190903155403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('UPDATE player SET updated_at = NOW()');
        $this->addSql('ALTER TABLE player ADD photo_name VARCHAR(255) DEFAULT NULL, ADD photo_original_name VARCHAR(255) DEFAULT NULL, ADD photo_mime_type VARCHAR(255) DEFAULT NULL, ADD photo_size INT DEFAULT NULL, ADD photo_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP photo_name, DROP photo_original_name, DROP photo_mime_type, DROP photo_size, DROP photo_dimensions');
    }
}
