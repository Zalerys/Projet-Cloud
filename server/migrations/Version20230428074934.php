<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428074934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_db (id INT AUTO_INCREMENT NOT NULL, server_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_6275DC725E237E06 (name), INDEX IDX_6275DC721844E6B7 (server_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE database_user (database_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FFEE9405F0AA09DB (database_id), INDEX IDX_FFEE9405A76ED395 (user_id), PRIMARY KEY(database_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, storage_size DOUBLE PRECISION DEFAULT NULL, backups_folder_path VARCHAR(255) DEFAULT NULL, auto_backups_time TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_5A6DD5F65E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server_user (server_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_613A7A91844E6B7 (server_id), INDEX IDX_613A7A9A76ED395 (user_id), PRIMARY KEY(server_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, public_ssh_key VARCHAR(10000) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_db ADD CONSTRAINT FK_6275DC721844E6B7 FOREIGN KEY (server_id) REFERENCES server (id)');
        $this->addSql('ALTER TABLE database_user ADD CONSTRAINT FK_FFEE9405F0AA09DB FOREIGN KEY (database_id) REFERENCES program_db (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE database_user ADD CONSTRAINT FK_FFEE9405A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE server_user ADD CONSTRAINT FK_613A7A91844E6B7 FOREIGN KEY (server_id) REFERENCES server (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE server_user ADD CONSTRAINT FK_613A7A9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_db DROP FOREIGN KEY FK_6275DC721844E6B7');
        $this->addSql('ALTER TABLE database_user DROP FOREIGN KEY FK_FFEE9405F0AA09DB');
        $this->addSql('ALTER TABLE database_user DROP FOREIGN KEY FK_FFEE9405A76ED395');
        $this->addSql('ALTER TABLE server_user DROP FOREIGN KEY FK_613A7A91844E6B7');
        $this->addSql('ALTER TABLE server_user DROP FOREIGN KEY FK_613A7A9A76ED395');
        $this->addSql('DROP TABLE program_db');
        $this->addSql('DROP TABLE database_user');
        $this->addSql('DROP TABLE server');
        $this->addSql('DROP TABLE server_user');
        $this->addSql('DROP TABLE user');
    }
}
