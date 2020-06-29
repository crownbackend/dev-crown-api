<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200629113454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, image_file VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, published_at DATETIME NOT NULL, meta_description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_article (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_F1496C767294869C (article_id), INDEX IDX_F1496C76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_video (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_D55D42DD29C1004E (video_id), INDEX IDX_D55D42DDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_file VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playliste (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, topic_id INT DEFAULT NULL, content LONGTEXT NOT NULL, creates_at DATETIME NOT NULL, INDEX IDX_3E7B0BFB1F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_user (response_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2132DCD3FBF32840 (response_id), INDEX IDX_2132DCD3A76ED395 (user_id), PRIMARY KEY(response_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image_file VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, forum_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, resolve TINYINT(1) NOT NULL, close TINYINT(1) NOT NULL, INDEX IDX_9D40DE1B29CCBAD0 (forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic_user (topic_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B578B7FC1F55203D (topic_id), INDEX IDX_B578B7FCA76ED395 (user_id), PRIMARY KEY(topic_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, token_password VARCHAR(255) DEFAULT NULL, confirmation_token_created_at DATETIME DEFAULT NULL, token_password_created_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, last_login DATETIME DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, technology_id INT DEFAULT NULL, playliste_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, video_url LONGTEXT NOT NULL, created_at DATETIME NOT NULL, published_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, image_file VARCHAR(255) NOT NULL, name_file_video VARCHAR(255) NOT NULL, type_video INT NOT NULL, INDEX IDX_7CC7DA2C4235D463 (technology_id), INDEX IDX_7CC7DA2CEA02C715 (playliste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_user (video_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8A048B9529C1004E (video_id), INDEX IDX_8A048B95A76ED395 (user_id), PRIMARY KEY(video_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_article ADD CONSTRAINT FK_F1496C767294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment_article ADD CONSTRAINT FK_F1496C76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_video ADD CONSTRAINT FK_D55D42DD29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE comment_video ADD CONSTRAINT FK_D55D42DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE response_user ADD CONSTRAINT FK_2132DCD3FBF32840 FOREIGN KEY (response_id) REFERENCES response (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE response_user ADD CONSTRAINT FK_2132DCD3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE topic_user ADD CONSTRAINT FK_B578B7FC1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topic_user ADD CONSTRAINT FK_B578B7FCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CEA02C715 FOREIGN KEY (playliste_id) REFERENCES playliste (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE video_user ADD CONSTRAINT FK_8A048B9529C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_user ADD CONSTRAINT FK_8A048B95A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_article DROP FOREIGN KEY FK_F1496C767294869C');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B29CCBAD0');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CEA02C715');
        $this->addSql('ALTER TABLE response_user DROP FOREIGN KEY FK_2132DCD3FBF32840');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C4235D463');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB1F55203D');
        $this->addSql('ALTER TABLE topic_user DROP FOREIGN KEY FK_B578B7FC1F55203D');
        $this->addSql('ALTER TABLE comment_article DROP FOREIGN KEY FK_F1496C76A76ED395');
        $this->addSql('ALTER TABLE comment_video DROP FOREIGN KEY FK_D55D42DDA76ED395');
        $this->addSql('ALTER TABLE response_user DROP FOREIGN KEY FK_2132DCD3A76ED395');
        $this->addSql('ALTER TABLE topic_user DROP FOREIGN KEY FK_B578B7FCA76ED395');
        $this->addSql('ALTER TABLE video_user DROP FOREIGN KEY FK_8A048B95A76ED395');
        $this->addSql('ALTER TABLE comment_video DROP FOREIGN KEY FK_D55D42DD29C1004E');
        $this->addSql('ALTER TABLE video_user DROP FOREIGN KEY FK_8A048B9529C1004E');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comment_article');
        $this->addSql('DROP TABLE comment_video');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE playliste');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE response_user');
        $this->addSql('DROP TABLE technology');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE topic_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_user');
    }
}
