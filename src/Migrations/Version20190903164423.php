<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190903164423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('UPDATE news SET updated_at = NOW()');
        $this->addSql('ALTER TABLE news ADD photo_original_name VARCHAR(255) DEFAULT NULL, ADD photo_mime_type VARCHAR(255) DEFAULT NULL, ADD photo_size INT DEFAULT NULL, ADD photo_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE photo photo_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news ADD photo VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP updated_at, DROP photo_name, DROP photo_original_name, DROP photo_mime_type, DROP photo_size, DROP photo_dimensions');
    }
}
