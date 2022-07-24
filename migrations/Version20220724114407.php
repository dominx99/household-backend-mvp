<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220724114407 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX email_uidx ON user (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX email_uidx ON user');
    }
}
