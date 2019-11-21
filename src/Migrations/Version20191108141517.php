<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191108141517 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create the about section table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE about(
                    id SERIAL PRIMARY KEY,
                    content LONGTEXT,
                    updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    );');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE about;');
    }
}
