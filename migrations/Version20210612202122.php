<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210612202122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A56E2C1A54 FOREIGN KEY (candid_id) REFERENCES candidate (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5BCF5E72D ON demande (categorie_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A56E2C1A54 ON demande (candid_id)');
        $this->addSql('ALTER TABLE offre ADD categorie_id INT NOT NULL, ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AF86866FBCF5E72D ON offre (categorie_id)');
        $this->addSql('CREATE INDEX IDX_AF86866F67B3B43D ON offre (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5BCF5E72D');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A56E2C1A54');
        $this->addSql('DROP INDEX IDX_2694D7A5BCF5E72D ON demande');
        $this->addSql('DROP INDEX IDX_2694D7A56E2C1A54 ON demande');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBCF5E72D');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F67B3B43D');
        $this->addSql('DROP INDEX IDX_AF86866FBCF5E72D ON offre');
        $this->addSql('DROP INDEX IDX_AF86866F67B3B43D ON offre');
        $this->addSql('ALTER TABLE offre DROP categorie_id, DROP users_id');
    }
}
