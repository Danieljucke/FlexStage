<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921114353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_salle (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(30) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, service_id INT NOT NULL, nom_salle VARCHAR(50) NOT NULL, statut TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4E977E5CBCF5E72D (categorie_id), INDEX IDX_4E977E5CED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(50) NOT NULL, code_service VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_salle (id)');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EEA73F0036');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EEE946114A');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE98260155');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D131A4F72');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962DE946114A');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D98260155');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962DA73F0036');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, province_id INT DEFAULT NULL, ville_id INT DEFAULT NULL, nom_commune VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E2E2D1EEA73F0036 (ville_id), INDEX IDX_E2E2D1EE98260155 (region_id), INDEX IDX_E2E2D1EEE946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, province_id INT DEFAULT NULL, ville_id INT DEFAULT NULL, commune_id INT DEFAULT NULL, nom_quartier VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_FEE8962D131A4F72 (commune_id), INDEX IDX_FEE8962D98260155 (region_id), INDEX IDX_FEE8962DE946114A (province_id), INDEX IDX_FEE8962DA73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, nom VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sexe VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, etat_civil VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, username VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EEA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EEE946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962DE946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962DA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CBCF5E72D');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CED5CA9E6');
        $this->addSql('DROP TABLE categorie_salle');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE service');
    }
}
