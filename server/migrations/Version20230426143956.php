<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426143956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_db (id INT AUTO_INCREMENT NOT NULL, server_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6275DC721844E6B7 (server_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, storage_size DOUBLE PRECISION DEFAULT NULL, backups_folder_path VARCHAR(255) DEFAULT NULL, auto_backups_time TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, public_ssh_key VARCHAR(1000) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_server (user_id INT NOT NULL, server_id INT NOT NULL, INDEX IDX_3F3FCECBA76ED395 (user_id), INDEX IDX_3F3FCECB1844E6B7 (server_id), PRIMARY KEY(user_id, server_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_database (user_id INT NOT NULL, database_id INT NOT NULL, INDEX IDX_29DEE22EA76ED395 (user_id), INDEX IDX_29DEE22EF0AA09DB (database_id), PRIMARY KEY(user_id, database_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_db ADD CONSTRAINT FK_6275DC721844E6B7 FOREIGN KEY (server_id) REFERENCES server (id)');
        $this->addSql('ALTER TABLE user_server ADD CONSTRAINT FK_3F3FCECBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_server ADD CONSTRAINT FK_3F3FCECB1844E6B7 FOREIGN KEY (server_id) REFERENCES server (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_database ADD CONSTRAINT FK_29DEE22EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_database ADD CONSTRAINT FK_29DEE22EF0AA09DB FOREIGN KEY (database_id) REFERENCES program_db (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_db DROP FOREIGN KEY FK_6275DC721844E6B7');
        $this->addSql('ALTER TABLE user_server DROP FOREIGN KEY FK_3F3FCECBA76ED395');
        $this->addSql('ALTER TABLE user_server DROP FOREIGN KEY FK_3F3FCECB1844E6B7');
        $this->addSql('ALTER TABLE user_database DROP FOREIGN KEY FK_29DEE22EA76ED395');
        $this->addSql('ALTER TABLE user_database DROP FOREIGN KEY FK_29DEE22EF0AA09DB');
        $this->addSql('DROP TABLE program_db');
        $this->addSql('DROP TABLE server');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_server');
        $this->addSql('DROP TABLE user_database');
    }
}
