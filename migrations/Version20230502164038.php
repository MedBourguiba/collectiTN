<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502164038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, partenaire_id INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, date_avis DATETIME NOT NULL, INDEX IDX_8F91ABF019EB6921 (client_id), UNIQUE INDEX UNIQ_8F91ABF098DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE bids (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, user_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3FF09E1E126F525E (item_id), UNIQUE INDEX UNIQ_3FF09E1EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE categorie_musee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, partner_id INT NOT NULL, winner_id INT DEFAULT NULL, watchlist_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_time DATE NOT NULL, end_time DATE NOT NULL, starting_price DOUBLE PRECISION NOT NULL, estimated_price DOUBLE PRECISION NOT NULL, status SMALLINT NOT NULL, img VARCHAR(255) NOT NULL, INDEX IDX_1F1B251E12469DE2 (category_id), UNIQUE INDEX UNIQ_1F1B251E9393F8FE (partner_id), UNIQUE INDEX UNIQ_1F1B251E5DFCD4B8 (winner_id), INDEX IDX_1F1B251E83DD0D94 (watchlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE musee (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8884C873BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, amount VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', paid_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_6D28840D126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE piece_musee (id INT AUTO_INCREMENT NOT NULL, musee_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, posted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9A374918D90009CE (musee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, user_id INT DEFAULT NULL, sujet VARCHAR(255) NOT NULL, message TEXT NOT NULL, date_reclamation DATETIME NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_CE606404126F525E (item_id), INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, roles ENUM(\'ROLE_ADMIN\', \'ROLE_CLIENT\', \'ROLE_PARTNER\') NOT NULL COMMENT \'(DC2Type:user_role_enum)\', telephone INT NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, datenaiss DATE NOT NULL, is_verified TINYINT(1) NOT NULL, img VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE watchlist (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_340388D39D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF019EB6921 FOREIGN KEY (client_id) REFERENCES utilisateur (id)');
        // $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF098DE13AC FOREIGN KEY (partenaire_id) REFERENCES utilisateur (id)');
        // $this->addSql('ALTER TABLE bids ADD CONSTRAINT FK_3FF09E1E126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        // $this->addSql('ALTER TABLE bids ADD CONSTRAINT FK_3FF09E1EA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        // $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        // $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E9393F8FE FOREIGN KEY (partner_id) REFERENCES utilisateur (id)');
        // $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES utilisateur (id)');
        // $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E83DD0D94 FOREIGN KEY (watchlist_id) REFERENCES watchlist (id)');
        // $this->addSql('ALTER TABLE musee ADD CONSTRAINT FK_8884C873BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_musee (id)');
        // $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        // $this->addSql('ALTER TABLE piece_musee ADD CONSTRAINT FK_9A374918D90009CE FOREIGN KEY (musee_id) REFERENCES musee (id)');
        // $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        // $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        // $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        // $this->addSql('ALTER TABLE watchlist ADD CONSTRAINT FK_340388D39D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF019EB6921');
        // $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF098DE13AC');
        // $this->addSql('ALTER TABLE bids DROP FOREIGN KEY FK_3FF09E1E126F525E');
        // $this->addSql('ALTER TABLE bids DROP FOREIGN KEY FK_3FF09E1EA76ED395');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E12469DE2');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E9393F8FE');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E5DFCD4B8');
        // $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E83DD0D94');
        // $this->addSql('ALTER TABLE musee DROP FOREIGN KEY FK_8884C873BCF5E72D');
        // $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D126F525E');
        // $this->addSql('ALTER TABLE piece_musee DROP FOREIGN KEY FK_9A374918D90009CE');
        // $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404126F525E');
        // $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        // $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        // $this->addSql('ALTER TABLE watchlist DROP FOREIGN KEY FK_340388D39D86650F');
        // $this->addSql('DROP TABLE avis');
        // $this->addSql('DROP TABLE bids');
        // $this->addSql('DROP TABLE categorie_musee');
        // $this->addSql('DROP TABLE category');
        // $this->addSql('DROP TABLE item');
        // $this->addSql('DROP TABLE musee');
        // $this->addSql('DROP TABLE payment');
        // $this->addSql('DROP TABLE piece_musee');
        // $this->addSql('DROP TABLE reclamation');
        // $this->addSql('DROP TABLE reset_password_request');
        // $this->addSql('DROP TABLE utilisateur');
        // $this->addSql('DROP TABLE watchlist');
        // $this->addSql('DROP TABLE messenger_messages');
    }
}
