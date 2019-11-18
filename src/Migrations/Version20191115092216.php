<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191115092216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Table news creation';
    }

    public function up(Schema $schema) : void
    {
      $this->addSql('CREATE TABLE news (
          id SERIAL PRIMARY KEY,
          title VARCHAR(255) NOT NULL UNIQUE,
          description TEXT NOT NULL,
          publication_date DATETIME NOT NULL DEFAULT NOW(),
          last_edit_date DATETIME,
          author_id INTEGER REFERENCES user(id_user) ON DELETE CASCADE
      ) ENGINE=InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE news');
    }
}
