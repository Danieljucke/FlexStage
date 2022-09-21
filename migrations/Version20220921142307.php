<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921142307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD nom VARCHAR(20) DEFAULT NULL, ADD prenom VARCHAR(20) DEFAULT NULL, ADD sexe VARCHAR(6) DEFAULT NULL, ADD date_naissance DATE DEFAULT NULL, ADD lieu_naissance VARCHAR(20) DEFAULT NULL, ADD telephone VARCHAR(15) DEFAULT NULL, ADD etat_civil VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP nom, DROP prenom, DROP sexe, DROP date_naissance, DROP lieu_naissance, DROP telephone, DROP etat_civil');
    }
}
