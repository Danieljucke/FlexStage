<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922102144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hotel_categorie_hotel (hotel_id INT NOT NULL, categorie_hotel_id INT NOT NULL, INDEX IDX_476501643243BB18 (hotel_id), INDEX IDX_47650164AC4FA72 (categorie_hotel_id), PRIMARY KEY(hotel_id, categorie_hotel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel_categorie_hotel ADD CONSTRAINT FK_476501643243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotel_categorie_hotel ADD CONSTRAINT FK_47650164AC4FA72 FOREIGN KEY (categorie_hotel_id) REFERENCES categorie_hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotel ADD adresse_id INT NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED94DE7DC5C FOREIGN KEY (adresse_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_3535ED94DE7DC5C ON hotel (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel_categorie_hotel DROP FOREIGN KEY FK_476501643243BB18');
        $this->addSql('ALTER TABLE hotel_categorie_hotel DROP FOREIGN KEY FK_47650164AC4FA72');
        $this->addSql('DROP TABLE hotel_categorie_hotel');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED94DE7DC5C');
        $this->addSql('DROP INDEX IDX_3535ED94DE7DC5C ON hotel');
        $this->addSql('ALTER TABLE hotel DROP adresse_id');
    }
}
