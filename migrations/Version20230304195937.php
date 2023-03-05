<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304195937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, chat_id INT NOT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, state JSON DEFAULT NULL, last_activity DATE NOT NULL, UNIQUE INDEX UNIQ_47CC8C921A9A7125 (chat_id), UNIQUE INDEX UNIQ_47CC8C92A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moderator (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, chat_id INT NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6A30B2685E237E06 (name), UNIQUE INDEX UNIQ_6A30B2681A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, chat_id INT NOT NULL, priority VARCHAR(255) NOT NULL, published TINYINT(1) NOT NULL, moderate_state VARCHAR(255) NOT NULL, last_activity DATE NOT NULL, UNIQUE INDEX UNIQ_5A8A6C8DA76ED395 (user_id), UNIQUE INDEX UNIQ_5A8A6C8D1A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, chat_id INT NOT NULL, username VARCHAR(255) NOT NULL, language_code VARCHAR(255) NOT NULL, post_id INT DEFAULT NULL, last_activity DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D6491A9A7125 (chat_id), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6494B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE moderator');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE `user`');
    }
}
