<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180915082652 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user (
            id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            firstname VARCHAR(255),
            lastname VARCHAR(255),
            phone VARCHAR(255),
            reset_password_token VARCHAR(255),
            reset_password_token_validity_date DATETIME
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }
}
