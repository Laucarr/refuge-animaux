<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260528124619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_shelter (user_id INT NOT NULL, shelter_id INT NOT NULL, INDEX IDX_291D790DA76ED395 (user_id), INDEX IDX_291D790D54053EC0 (shelter_id), PRIMARY KEY (user_id, shelter_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE user_shelter ADD CONSTRAINT FK_291D790DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_shelter ADD CONSTRAINT FK_291D790D54053EC0 FOREIGN KEY (shelter_id) REFERENCES shelter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_shelter DROP FOREIGN KEY FK_291D790DA76ED395');
        $this->addSql('ALTER TABLE user_shelter DROP FOREIGN KEY FK_291D790D54053EC0');
        $this->addSql('DROP TABLE user_shelter');
    }
}
