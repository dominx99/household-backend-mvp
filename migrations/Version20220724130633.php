<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220724130633 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shopping_list ADD shopping_list_group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A459F2EC0230 FOREIGN KEY (shopping_list_group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_3DC1A459F2EC0230 ON shopping_list (shopping_list_group_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shopping_list DROP FOREIGN KEY FK_3DC1A459F2EC0230');
        $this->addSql('DROP INDEX IDX_3DC1A459F2EC0230 ON shopping_list');
        $this->addSql('ALTER TABLE shopping_list DROP shopping_list_group_id');
    }
}
