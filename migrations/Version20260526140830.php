<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260526140830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caretaker_shelter (caretaker_id INT NOT NULL, shelter_id INT NOT NULL, INDEX IDX_EBB331253F070B8B (caretaker_id), INDEX IDX_EBB3312554053EC0 (shelter_id), PRIMARY KEY (caretaker_id, shelter_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE caretaker_shelter ADD CONSTRAINT FK_EBB331253F070B8B FOREIGN KEY (caretaker_id) REFERENCES caretaker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE caretaker_shelter ADD CONSTRAINT FK_EBB3312554053EC0 FOREIGN KEY (shelter_id) REFERENCES shelter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caretaker_shelter DROP FOREIGN KEY FK_EBB331253F070B8B');
        $this->addSql('ALTER TABLE caretaker_shelter DROP FOREIGN KEY FK_EBB3312554053EC0');
        $this->addSql('DROP TABLE caretaker_shelter');
    }
}
