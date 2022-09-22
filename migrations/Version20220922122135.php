<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922122135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role_privillege DROP FOREIGN KEY FK_5F0FDF09707EF232');
        $this->addSql('ALTER TABLE role_privillege DROP FOREIGN KEY FK_5F0FDF09D60322AC');
        $this->addSql('DROP TABLE role_privillege');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_privillege (role_id INT NOT NULL, privillege_id INT NOT NULL, INDEX IDX_5F0FDF09D60322AC (role_id), INDEX IDX_5F0FDF09707EF232 (privillege_id), PRIMARY KEY(role_id, privillege_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE role_privillege ADD CONSTRAINT FK_5F0FDF09707EF232 FOREIGN KEY (privillege_id) REFERENCES privillege (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_privillege ADD CONSTRAINT FK_5F0FDF09D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
    }
}
