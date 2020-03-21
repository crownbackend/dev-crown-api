<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200321122459 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, forum_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, resolve TINYINT(1) NOT NULL, close TINYINT(1) NOT NULL, INDEX IDX_9D40DE1B29CCBAD0 (forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic_user (topic_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B578B7FC1F55203D (topic_id), INDEX IDX_B578B7FCA76ED395 (user_id), PRIMARY KEY(topic_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playliste (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_video (id INT AUTO_INCREMENT NOT NULL, video_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D55D42DD29C1004E (video_id), INDEX IDX_D55D42DDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image_file VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_article (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F1496C767294869C (article_id), INDEX IDX_F1496C76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, topic_id INT DEFAULT NULL, content LONGTEXT NOT NULL, creates_at DATETIME NOT NULL, INDEX IDX_3E7B0BFB1F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_user (response_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2132DCD3FBF32840 (response_id), INDEX IDX_2132DCD3A76ED395 (user_id), PRIMARY KEY(response_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, image_file VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, published_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_file VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE topic_user ADD CONSTRAINT FK_B578B7FC1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topic_user ADD CONSTRAINT FK_B578B7FCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment_video ADD CONSTRAINT FK_D55D42DD29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE comment_video ADD CONSTRAINT FK_D55D42DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_article ADD CONSTRAINT FK_F1496C767294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment_article ADD CONSTRAINT FK_F1496C76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE response_user ADD CONSTRAINT FK_2132DCD3FBF32840 FOREIGN KEY (response_id) REFERENCES response (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE response_user ADD CONSTRAINT FK_2132DCD3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD technology_id INT DEFAULT NULL, ADD playliste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CEA02C715 FOREIGN KEY (playliste_id) REFERENCES playliste (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C4235D463 ON video (technology_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CEA02C715 ON video (playliste_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE topic_user DROP FOREIGN KEY FK_B578B7FC1F55203D');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB1F55203D');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CEA02C715');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C4235D463');
        $this->addSql('ALTER TABLE response_user DROP FOREIGN KEY FK_2132DCD3FBF32840');
        $this->addSql('ALTER TABLE comment_article DROP FOREIGN KEY FK_F1496C767294869C');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B29CCBAD0');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE topic_user');
        $this->addSql('DROP TABLE playliste');
        $this->addSql('DROP TABLE comment_video');
        $this->addSql('DROP TABLE technology');
        $this->addSql('DROP TABLE comment_article');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE response_user');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE forum');
        $this->addSql('ALTER TABLE user DROP avatar');
        $this->addSql('DROP INDEX IDX_7CC7DA2C4235D463 ON video');
        $this->addSql('DROP INDEX IDX_7CC7DA2CEA02C715 ON video');
        $this->addSql('ALTER TABLE video DROP technology_id, DROP playliste_id');
    }
}
