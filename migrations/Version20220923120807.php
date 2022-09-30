<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923120807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED94DE7DC5C');
        $this->addSql('DROP INDEX IDX_3535ED94DE7DC5C ON hotel');
        $this->addSql('ALTER TABLE hotel CHANGE adresse_id ville_id INT NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_3535ED9A73F0036 ON hotel (ville_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9A73F0036');
        $this->addSql('DROP INDEX IDX_3535ED9A73F0036 ON hotel');
        $this->addSql('ALTER TABLE hotel CHANGE ville_id adresse_id INT NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED94DE7DC5C FOREIGN KEY (adresse_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_3535ED94DE7DC5C ON hotel (adresse_id)');
    }
}
