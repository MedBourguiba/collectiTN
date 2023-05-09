<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507223726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE avis CHANGE partenaire_id partenaire_id INT NOT NULL');
        // $this->addSql('DROP INDEX UNIQ_3FF09E1EA76ED395 ON bids');
        // $this->addSql('ALTER TABLE bids CHANGE user_id user_id INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_3FF09E1EA76ED395 ON bids (user_id)');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E5DFCD4B8');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E9393F8FE');
        // $this->addSql('DROP INDEX UNIQ_1F1B251E9393F8FE ON item');
        // $this->addSql('ALTER TABLE item CHANGE category_id category_id INT NOT NULL, CHANGE partner_id partner_id INT NOT NULL, CHANGE img img VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E9393F8FE FOREIGN KEY (partner_id) REFERENCES utilisateur (id)');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E9393F8FE ON item (partner_id)');
        // $this->addSql('ALTER TABLE payment CHANGE amount amount VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE reclamation CHANGE email email VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE utilisateur CHANGE datenaiss datenaiss DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE avis CHANGE partenaire_id partenaire_id INT DEFAULT NULL');
        // $this->addSql('DROP INDEX UNIQ_3FF09E1EA76ED395 ON bids');
        // $this->addSql('ALTER TABLE bids CHANGE user_id user_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        // $this->addSql('CREATE INDEX UNIQ_3FF09E1EA76ED395 ON bids (user_id)');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E9393F8FE');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E5DFCD4B8');
        // $this->addSql('DROP INDEX UNIQ_1F1B251E9393F8FE ON item');
        // $this->addSql('ALTER TABLE item CHANGE category_id category_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE img img VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E9393F8FE FOREIGN KEY (partner_id) REFERENCES utilisateur (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES utilisateur (id) ON UPDATE CASCADE');
        // $this->addSql('CREATE INDEX UNIQ_1F1B251E9393F8FE ON item (partner_id)');
        // $this->addSql('ALTER TABLE payment CHANGE amount amount DOUBLE PRECISION NOT NULL');
        // $this->addSql('ALTER TABLE reclamation CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE utilisateur CHANGE datenaiss datenaiss DATE DEFAULT NULL');
    }
}
