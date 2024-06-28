<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628123031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat_room (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D403CCDAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, trick_group_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D8F0A91E9B875DF8 (trick_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_comment (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F7292B34B281BE2E (trick_id), INDEX IDX_F7292B34A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_picture (id INT AUTO_INCREMENT NOT NULL, url LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_picture_trick (trick_picture_id INT NOT NULL, trick_id INT NOT NULL, INDEX IDX_3FC3847267CD2D22 (trick_picture_id), INDEX IDX_3FC38472B281BE2E (trick_id), PRIMARY KEY(trick_picture_id, trick_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_video (id INT AUTO_INCREMENT NOT NULL, url LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_video_trick (trick_video_id INT NOT NULL, trick_id INT NOT NULL, INDEX IDX_D9A5C7D54C1284F1 (trick_video_id), INDEX IDX_D9A5C7D5B281BE2E (trick_id), PRIMARY KEY(trick_video_id, trick_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, password LONGTEXT NOT NULL, email VARCHAR(255) NOT NULL, token LONGTEXT DEFAULT NULL, logo LONGTEXT DEFAULT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat_room ADD CONSTRAINT FK_D403CCDAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E9B875DF8 FOREIGN KEY (trick_group_id) REFERENCES trick_group (id)');
        $this->addSql('ALTER TABLE trick_comment ADD CONSTRAINT FK_F7292B34B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE trick_comment ADD CONSTRAINT FK_F7292B34A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trick_picture_trick ADD CONSTRAINT FK_3FC3847267CD2D22 FOREIGN KEY (trick_picture_id) REFERENCES trick_picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_picture_trick ADD CONSTRAINT FK_3FC38472B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_video_trick ADD CONSTRAINT FK_D9A5C7D54C1284F1 FOREIGN KEY (trick_video_id) REFERENCES trick_video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_video_trick ADD CONSTRAINT FK_D9A5C7D5B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_room DROP FOREIGN KEY FK_D403CCDAA76ED395');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E9B875DF8');
        $this->addSql('ALTER TABLE trick_comment DROP FOREIGN KEY FK_F7292B34B281BE2E');
        $this->addSql('ALTER TABLE trick_comment DROP FOREIGN KEY FK_F7292B34A76ED395');
        $this->addSql('ALTER TABLE trick_picture_trick DROP FOREIGN KEY FK_3FC3847267CD2D22');
        $this->addSql('ALTER TABLE trick_picture_trick DROP FOREIGN KEY FK_3FC38472B281BE2E');
        $this->addSql('ALTER TABLE trick_video_trick DROP FOREIGN KEY FK_D9A5C7D54C1284F1');
        $this->addSql('ALTER TABLE trick_video_trick DROP FOREIGN KEY FK_D9A5C7D5B281BE2E');
        $this->addSql('DROP TABLE chat_room');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE trick_comment');
        $this->addSql('DROP TABLE trick_group');
        $this->addSql('DROP TABLE trick_picture');
        $this->addSql('DROP TABLE trick_picture_trick');
        $this->addSql('DROP TABLE trick_video');
        $this->addSql('DROP TABLE trick_video_trick');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
