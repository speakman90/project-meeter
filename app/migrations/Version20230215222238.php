<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215222238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE activities_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE gender_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE likes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE activities (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE activities_users (activities_id INT NOT NULL, users_id INT NOT NULL, PRIMARY KEY(activities_id, users_id))');
        $this->addSql('CREATE INDEX IDX_D70A863A2A4DB562 ON activities_users (activities_id)');
        $this->addSql('CREATE INDEX IDX_D70A863A67B3B43D ON activities_users (users_id)');
        $this->addSql('CREATE TABLE gender (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE likes (id INT NOT NULL, date_match DATE DEFAULT NULL, trash BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messages (id INT NOT NULL, likes_id INT NOT NULL, user_sender_id INT NOT NULL, content TEXT NOT NULL, date_send TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB021E962F23775F ON messages (likes_id)');
        $this->addSql('CREATE INDEX IDX_DB021E96F6C43E79 ON messages (user_sender_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, gender_id INT DEFAULT NULL, like1_id INT DEFAULT NULL, like2_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, create_date DATE NOT NULL, biography TEXT DEFAULT NULL, profil_photos JSON NOT NULL, city VARCHAR(255) DEFAULT NULL, job VARCHAR(255) DEFAULT NULL, orientations JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE INDEX IDX_1483A5E9708A0E0 ON users (gender_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E91E3EE7E9 ON users (like1_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9C8B4807 ON users (like2_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE activities_users ADD CONSTRAINT FK_D70A863A2A4DB562 FOREIGN KEY (activities_id) REFERENCES activities (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activities_users ADD CONSTRAINT FK_D70A863A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E962F23775F FOREIGN KEY (likes_id) REFERENCES likes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F6C43E79 FOREIGN KEY (user_sender_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E91E3EE7E9 FOREIGN KEY (like1_id) REFERENCES likes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9C8B4807 FOREIGN KEY (like2_id) REFERENCES likes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE activities_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE gender_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE likes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE messages_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE activities_users DROP CONSTRAINT FK_D70A863A2A4DB562');
        $this->addSql('ALTER TABLE activities_users DROP CONSTRAINT FK_D70A863A67B3B43D');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E962F23775F');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E96F6C43E79');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E9708A0E0');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E91E3EE7E9');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E9C8B4807');
        $this->addSql('DROP TABLE activities');
        $this->addSql('DROP TABLE activities_users');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
