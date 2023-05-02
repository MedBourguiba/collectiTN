<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502164753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP INDEX UNIQ_3FF09E1EA76ED395 ON bids');
        // $this->addSql('ALTER TABLE bids CHANGE user_id user_id INT NOT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_3FF09E1EA76ED395 ON bids (user_id)');
        // $this->addSql('ALTER TABLE item ADD watchlist_id INT DEFAULT NULL, CHANGE category_id category_id INT NOT NULL, CHANGE partner_id partner_id INT NOT NULL, CHANGE img img VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E83DD0D94 FOREIGN KEY (watchlist_id) REFERENCES watchlist (id)');
        // $this->addSql('CREATE INDEX IDX_1F1B251E83DD0D94 ON item (watchlist_id)');
        // $this->addSql('ALTER TABLE payment CHANGE amount amount FLOAT NOT NULL');
        // $this->addSql('ALTER TABLE reclamation CHANGE email email VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP INDEX UNIQ_3FF09E1EA76ED395 ON bids');
        // $this->addSql('ALTER TABLE bids CHANGE user_id user_id INT DEFAULT NULL, CHANGE amount amount VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        // $this->addSql('CREATE INDEX UNIQ_3FF09E1EA76ED395 ON bids (user_id)');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E83DD0D94');
        // $this->addSql('DROP INDEX IDX_1F1B251E83DD0D94 ON item');
        // $this->addSql('ALTER TABLE item DROP watchlist_id, CHANGE category_id category_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE img img VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE payment CHANGE amount amount DOUBLE PRECISION NOT NULL');
        // $this->addSql('ALTER TABLE reclamation CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }
}
