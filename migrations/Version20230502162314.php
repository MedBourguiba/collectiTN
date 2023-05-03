<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502162314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE watchlist (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_340388D39D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE watchlist ADD CONSTRAINT FK_340388D39D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
        // // $this->addSql('ALTER TABLE avis DROP note');
        // // $this->addSql('DROP INDEX UNIQ_3FF09E1EA76ED395 ON bids');
        // // $this->addSql('ALTER TABLE bids CHANGE user_id user_id INT NOT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        // // $this->addSql('CREATE UNIQUE INDEX UNIQ_3FF09E1EA76ED395 ON bids (user_id)');
        // $this->addSql('ALTER TABLE item ADD watchlist_id INT DEFAULT NULL, CHANGE category_id category_id INT NOT NULL, CHANGE partner_id partner_id INT NOT NULL, CHANGE img img VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E83DD0D94 FOREIGN KEY (watchlist_id) REFERENCES watchlist (id)');
        // $this->addSql('CREATE INDEX IDX_1F1B251E83DD0D94 ON item (watchlist_id)');
        // $this->addSql('ALTER TABLE payment CHANGE amount amount VARCHAR(255) NOT NULL');
        // $this->addSql('ALTER TABLE reclamation CHANGE email email VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E83DD0D94');
        // $this->addSql('ALTER TABLE watchlist DROP FOREIGN KEY FK_340388D39D86650F');
        // $this->addSql('DROP TABLE watchlist');
        // $this->addSql('ALTER TABLE avis ADD note INT DEFAULT NULL');
        // $this->addSql('DROP INDEX UNIQ_3FF09E1EA76ED395 ON bids');
        // $this->addSql('ALTER TABLE bids CHANGE user_id user_id INT DEFAULT NULL, CHANGE amount amount VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        // $this->addSql('CREATE INDEX UNIQ_3FF09E1EA76ED395 ON bids (user_id)');
        // $this->addSql('DROP INDEX IDX_1F1B251E83DD0D94 ON item');
        // $this->addSql('ALTER TABLE item DROP watchlist_id, CHANGE category_id category_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE img img VARCHAR(255) DEFAULT NULL');
        // $this->addSql('ALTER TABLE payment CHANGE amount amount DOUBLE PRECISION NOT NULL');
        // $this->addSql('ALTER TABLE reclamation CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }
}
