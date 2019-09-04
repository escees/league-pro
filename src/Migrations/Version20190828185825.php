<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190828185825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO media (updated_at, file_key, name) VALUES (NOW(), \'homepage.banner1\', \'Homepage Banner 1\'), (NOW(), \'homepage.banner2\', \'Homepage banner 2\'), (NOW(), \'homepage.banner3\', \'Homepage banner 3\'), (NOW(), \'team_list.banner1\', \'Team list banner 1\')');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DELETE FROM media');
    }
}
