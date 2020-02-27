<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225134047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, photo_id INT NOT NULL, categorie_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description_courte VARCHAR(255) NOT NULL, description_longue LONGTEXT NOT NULL, prix NUMERIC(11, 2) NOT NULL, adresse VARCHAR(50) NOT NULL, ville VARCHAR(20) NOT NULL, cp VARCHAR(5) NOT NULL, pays VARCHAR(20) NOT NULL, date_enregistrement DATETIME NOT NULL, INDEX IDX_F65593E56A99F74A (membre_id), UNIQUE INDEX UNIQ_F65593E57E9E4C8C (photo_id), INDEX IDX_F65593E5BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, motscles LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, annonce_id INT NOT NULL, commentaire LONGTEXT NOT NULL, date_enregistrement DATETIME NOT NULL, INDEX IDX_67F068BC6A99F74A (membre_id), UNIQUE INDEX UNIQ_67F068BC8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(20) NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, telephone VARCHAR(20) NOT NULL, civilite VARCHAR(1) NOT NULL, date_enregistrement DATETIME NOT NULL, UNIQUE INDEX UNIQ_F6B4FB29E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, membre_notant_id INT DEFAULT NULL, membre_note_id INT DEFAULT NULL, note INT NOT NULL, avis LONGTEXT NOT NULL, date_enregistrement DATETIME NOT NULL, INDEX IDX_CFBDFA1444D63573 (membre_notant_id), INDEX IDX_CFBDFA1494CA0AE8 (membre_note_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, photo1 VARCHAR(255) NOT NULL, photo2 VARCHAR(255) DEFAULT NULL, photo3 VARCHAR(255) DEFAULT NULL, photo4 VARCHAR(255) DEFAULT NULL, photo5 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E56A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E57E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1444D63573 FOREIGN KEY (membre_notant_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1494CA0AE8 FOREIGN KEY (membre_note_id) REFERENCES membre (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8805AB2F');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BCF5E72D');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E56A99F74A');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6A99F74A');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1444D63573');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1494CA0AE8');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E57E9E4C8C');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE photo');
    }
}
