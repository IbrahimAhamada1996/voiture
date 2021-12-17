<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216205522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE secretaire CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE secretaire ADD CONSTRAINT FK_7DB5C2D0BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visiteur CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE visiteur ADD CONSTRAINT FK_4EA587B8BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE admin CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE client CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE secretaire DROP FOREIGN KEY FK_7DB5C2D0BF396750');
        $this->addSql('ALTER TABLE secretaire CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE visiteur DROP FOREIGN KEY FK_4EA587B8BF396750');
        $this->addSql('ALTER TABLE visiteur CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
