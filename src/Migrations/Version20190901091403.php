<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190901091403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('UPDATE team SET updated_at = NOW()');
        $this->addSql('ALTER TABLE team ADD crest_name VARCHAR(255) DEFAULT NULL, ADD crest_original_name VARCHAR(255) DEFAULT NULL, ADD crest_mime_type VARCHAR(255) DEFAULT NULL, ADD crest_size INT DEFAULT NULL, ADD crest_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', ADD photo_name VARCHAR(255) DEFAULT NULL, ADD photo_original_name VARCHAR(255) DEFAULT NULL, ADD photo_mime_type VARCHAR(255) DEFAULT NULL, ADD photo_size INT DEFAULT NULL, ADD photo_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP crest, DROP photo');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team ADD crest LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:object)\', ADD photo LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:object)\', DROP updated_at, DROP crest_name, DROP crest_original_name, DROP crest_mime_type, DROP crest_size, DROP crest_dimensions, DROP photo_name, DROP photo_original_name, DROP photo_mime_type, DROP photo_size, DROP photo_dimensions');
    }
}
