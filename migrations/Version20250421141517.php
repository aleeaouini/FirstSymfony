<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421141517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD COLUMN title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book ADD COLUMN author VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book ADD COLUMN price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE book ADD COLUMN description CLOB NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO book (id) SELECT id FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
    }
}
