<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306125239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE likes ADD user1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE likes ADD user2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D56AE248B FOREIGN KEY (user1_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D441B8B65 FOREIGN KEY (user2_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_49CA4E7D56AE248B ON likes (user1_id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D441B8B65 ON likes (user2_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT FK_49CA4E7D56AE248B');
        $this->addSql('ALTER TABLE likes DROP CONSTRAINT FK_49CA4E7D441B8B65');
        $this->addSql('DROP INDEX IDX_49CA4E7D56AE248B');
        $this->addSql('DROP INDEX IDX_49CA4E7D441B8B65');
        $this->addSql('ALTER TABLE likes DROP user1_id');
        $this->addSql('ALTER TABLE likes DROP user2_id');
    }
}
