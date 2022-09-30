<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930113821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_hotel (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, nom_hotel VARCHAR(255) NOT NULL, nombre_etoiles SMALLINT NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_3535ED9A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_categorie_hotel (hotel_id INT NOT NULL, categorie_hotel_id INT NOT NULL, INDEX IDX_476501643243BB18 (hotel_id), INDEX IDX_47650164AC4FA72 (categorie_hotel_id), PRIMARY KEY(hotel_id, categorie_hotel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE hotel_categorie_hotel ADD CONSTRAINT FK_476501643243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotel_categorie_hotel ADD CONSTRAINT FK_47650164AC4FA72 FOREIGN KEY (categorie_hotel_id) REFERENCES categorie_hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_salle DROP nombre_etoile');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9A73F0036');
        $this->addSql('ALTER TABLE hotel_categorie_hotel DROP FOREIGN KEY FK_476501643243BB18');
        $this->addSql('ALTER TABLE hotel_categorie_hotel DROP FOREIGN KEY FK_47650164AC4FA72');
        $this->addSql('DROP TABLE categorie_hotel');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE hotel_categorie_hotel');
        $this->addSql('ALTER TABLE categorie_salle ADD nombre_etoile INT NOT NULL');
    }
}
