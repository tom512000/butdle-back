<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111163020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person ADD daily_person_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176A07FA25D FOREIGN KEY (daily_person_id) REFERENCES daily_person (id)');
        $this->addSql('CREATE INDEX IDX_34DCD176A07FA25D ON person (daily_person_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176A07FA25D');
        $this->addSql('DROP INDEX IDX_34DCD176A07FA25D ON person');
        $this->addSql('ALTER TABLE person DROP daily_person_id');
    }
}
