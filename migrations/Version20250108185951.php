<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108185951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, gender VARCHAR(5) NOT NULL, job VARCHAR(20) NOT NULL, status VARCHAR(20) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_subject (person_id INT NOT NULL, subject_id INT NOT NULL, INDEX IDX_D9508DF3217BBB47 (person_id), INDEX IDX_D9508DF323EDC87 (subject_id), PRIMARY KEY(person_id, subject_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person_subject ADD CONSTRAINT FK_D9508DF3217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person_subject ADD CONSTRAINT FK_D9508DF323EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person_subject DROP FOREIGN KEY FK_D9508DF3217BBB47');
        $this->addSql('ALTER TABLE person_subject DROP FOREIGN KEY FK_D9508DF323EDC87');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE person_subject');
        $this->addSql('DROP TABLE subject');
    }
}
