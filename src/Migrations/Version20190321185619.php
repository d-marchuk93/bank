<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321185619 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE deposit (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, sum NUMERIC(10, 2) NOT NULL, percent NUMERIC(5, 2) NOT NULL, balance NUMERIC(10, 2) NOT NULL, currency_id INT NOT NULL, date_opened DATETIME NOT NULL, INDEX IDX_95DB9D3919EB6921 (client_id), INDEX IDX_95DB9D3938248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deposit ADD CONSTRAINT FK_95DB9D3919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE deposit ADD CONSTRAINT FK_95DB9D3938248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE deposit');
    }
}
