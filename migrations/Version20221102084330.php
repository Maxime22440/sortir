<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221102084330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant ADD username VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD mot_passe VARCHAR(255) NOT NULL, CHANGE campus_id campus_id INT DEFAULT NULL, CHANGE telephone telephone VARCHAR(20) DEFAULT NULL, CHANGE mail mail VARCHAR(180) DEFAULT NULL, CHANGE mot_de_passe password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D79F6B11F85E0677 ON participant (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_D79F6B11F85E0677 ON participant');
        $this->addSql('ALTER TABLE participant ADD mot_de_passe VARCHAR(255) NOT NULL, DROP username, DROP roles, DROP password, DROP mot_passe, CHANGE campus_id campus_id INT NOT NULL, CHANGE telephone telephone VARCHAR(10) NOT NULL, CHANGE mail mail VARCHAR(180) NOT NULL');
    }
}
