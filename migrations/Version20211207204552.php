<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211207204552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctor (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', external_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1FC0F36A9F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slot (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', doctor_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', date_from DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_to DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', duration INT NOT NULL, INDEX IDX_AC0E206787F4FB17 (doctor_id), UNIQUE INDEX UNIQ_AC0E206787F4FB1799C42884D02983FF (doctor_id, date_from, date_to), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E206787F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slot DROP FOREIGN KEY FK_AC0E206787F4FB17');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE slot');
    }
}
