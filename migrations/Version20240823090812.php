<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240823090812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick_picture_trick DROP FOREIGN KEY FK_3FC38472B281BE2E');
        $this->addSql('ALTER TABLE trick_picture_trick DROP FOREIGN KEY FK_3FC3847267CD2D22');
        $this->addSql('DROP TABLE trick_picture_trick');
        $this->addSql('ALTER TABLE trick_picture ADD trick_id INT NOT NULL');
        $this->addSql('ALTER TABLE trick_picture ADD CONSTRAINT FK_758636D1B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_758636D1B281BE2E ON trick_picture (trick_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trick_picture_trick (trick_picture_id INT NOT NULL, trick_id INT NOT NULL, INDEX IDX_3FC3847267CD2D22 (trick_picture_id), INDEX IDX_3FC38472B281BE2E (trick_id), PRIMARY KEY(trick_picture_id, trick_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE trick_picture_trick ADD CONSTRAINT FK_3FC38472B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_picture_trick ADD CONSTRAINT FK_3FC3847267CD2D22 FOREIGN KEY (trick_picture_id) REFERENCES trick_picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_picture DROP FOREIGN KEY FK_758636D1B281BE2E');
        $this->addSql('DROP INDEX IDX_758636D1B281BE2E ON trick_picture');
        $this->addSql('ALTER TABLE trick_picture DROP trick_id');
    }
}
