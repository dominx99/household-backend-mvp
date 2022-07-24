<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220724185517 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE shopping_list_item (id INT AUTO_INCREMENT NOT NULL, shopping_list_id INT NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(255) DEFAULT \'units\' NOT NULL, amount INT DEFAULT 1 NOT NULL, INDEX IDX_4FB1C22423245BF9 (shopping_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shopping_list_item ADD CONSTRAINT FK_4FB1C22423245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE shopping_list_item');
    }
}
