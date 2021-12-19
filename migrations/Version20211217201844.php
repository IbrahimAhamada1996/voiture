<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211217201844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheter (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE louer (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, montant DOUBLE PRECISION NOT NULL, promotion DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typeOffre (id INT AUTO_INCREMENT NOT NULL, offre_id INT NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_E46D1C784CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, type_offre_id INT DEFAULT NULL, marque VARCHAR(255) NOT NULL, matricule VARCHAR(255) DEFAULT NULL, modele VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', couleur VARCHAR(255) NOT NULL, desciption LONGTEXT DEFAULT NULL, INDEX IDX_E9E2810F813777A6 (type_offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acheter ADD CONSTRAINT FK_6E0E9118BF396750 FOREIGN KEY (id) REFERENCES typeOffre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE louer ADD CONSTRAINT FK_D1EAF4DBF396750 FOREIGN KEY (id) REFERENCES typeOffre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE typeOffre ADD CONSTRAINT FK_E46D1C784CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F813777A6 FOREIGN KEY (type_offre_id) REFERENCES typeOffre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE typeOffre DROP FOREIGN KEY FK_E46D1C784CC8505A');
        $this->addSql('ALTER TABLE acheter DROP FOREIGN KEY FK_6E0E9118BF396750');
        $this->addSql('ALTER TABLE louer DROP FOREIGN KEY FK_D1EAF4DBF396750');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F813777A6');
        $this->addSql('DROP TABLE acheter');
        $this->addSql('DROP TABLE louer');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE typeOffre');
        $this->addSql('DROP TABLE voiture');
    }
}
