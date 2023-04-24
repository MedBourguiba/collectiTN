<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423000425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
      
        $this->addSql('ALTER TABLE item ADD winner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E5DFCD4B8 ON item (winner_id)');
     
    }

    public function down(Schema $schema): void
    {
    
      
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E5DFCD4B8');
        $this->addSql('DROP INDEX UNIQ_1F1B251E5DFCD4B8 ON item');
       
    }
}
