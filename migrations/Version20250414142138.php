<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414142138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add is_verified column to user table';
    }

    public function up(Schema $schema): void
    {
        // Ajoute une colonne 'is_verified' à la table 'user' sans la contrainte 'NOT NULL'
        $this->addSql('ALTER TABLE user ADD COLUMN is_verified BOOLEAN');

        // Met à jour les valeurs NULL dans la colonne 'is_verified' pour qu'elles soient '0'
        $this->addSql('UPDATE user SET is_verified = 0 WHERE is_verified IS NULL');

        // Crée une nouvelle table avec la contrainte 'NOT NULL' sur la colonne 'is_verified'
        $this->addSql('PRAGMA foreign_keys=off;');
        $this->addSql('CREATE TABLE user_new AS SELECT id, email, roles, password, is_verified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE user_new RENAME TO user');
        $this->addSql('PRAGMA foreign_keys=on;');
    }

    public function down(Schema $schema): void
    {
        // Annule l'ajout de la colonne 'is_verified'
        $this->addSql('ALTER TABLE user DROP COLUMN is_verified');
    }
}
