<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260526135913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_caretaker (animal_id INT NOT NULL, caretaker_id INT NOT NULL, INDEX IDX_290706348E962C16 (animal_id), INDEX IDX_290706343F070B8B (caretaker_id), PRIMARY KEY (animal_id, caretaker_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE animal_caretaker ADD CONSTRAINT FK_290706348E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_caretaker ADD CONSTRAINT FK_290706343F070B8B FOREIGN KEY (caretaker_id) REFERENCES caretaker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal ADD shelter_id INT NOT NULL, ADD species_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F54053EC0 FOREIGN KEY (shelter_id) REFERENCES shelter (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F54053EC0 ON animal (shelter_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FB2A1D860 ON animal (species_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_caretaker DROP FOREIGN KEY FK_290706348E962C16');
        $this->addSql('ALTER TABLE animal_caretaker DROP FOREIGN KEY FK_290706343F070B8B');
        $this->addSql('DROP TABLE animal_caretaker');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F54053EC0');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB2A1D860');
        $this->addSql('DROP INDEX IDX_6AAB231F54053EC0 ON animal');
        $this->addSql('DROP INDEX IDX_6AAB231FB2A1D860 ON animal');
        $this->addSql('ALTER TABLE animal DROP shelter_id, DROP species_id');
    }
}
