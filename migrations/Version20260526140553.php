<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260526140553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adoption ADD animal_id INT NOT NULL, ADD adopter_id INT NOT NULL');
        $this->addSql('ALTER TABLE adoption ADD CONSTRAINT FK_EDDEB6A98E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE adoption ADD CONSTRAINT FK_EDDEB6A9A0D47673 FOREIGN KEY (adopter_id) REFERENCES adopter (id)');
        $this->addSql('CREATE INDEX IDX_EDDEB6A98E962C16 ON adoption (animal_id)');
        $this->addSql('CREATE INDEX IDX_EDDEB6A9A0D47673 ON adoption (adopter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adoption DROP FOREIGN KEY FK_EDDEB6A98E962C16');
        $this->addSql('ALTER TABLE adoption DROP FOREIGN KEY FK_EDDEB6A9A0D47673');
        $this->addSql('DROP INDEX IDX_EDDEB6A98E962C16 ON adoption');
        $this->addSql('DROP INDEX IDX_EDDEB6A9A0D47673 ON adoption');
        $this->addSql('ALTER TABLE adoption DROP animal_id, DROP adopter_id');
    }
}
