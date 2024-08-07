<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240806161448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clausula (id INT AUTO_INCREMENT NOT NULL, contrato_id INT DEFAULT NULL, texto LONGTEXT NOT NULL, INDEX IDX_5D873D4C70AE7BF1 (contrato_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contratado (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, cpf_cnpj VARCHAR(255) NOT NULL, rg VARCHAR(30) NOT NULL, cep VARCHAR(10) NOT NULL, rua VARCHAR(255) NOT NULL, bairro VARCHAR(255) NOT NULL, cidade VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contratante (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, cpf_cnpj VARCHAR(255) NOT NULL, rg VARCHAR(30) NOT NULL, cep VARCHAR(10) NOT NULL, rua VARCHAR(255) NOT NULL, bairro VARCHAR(255) NOT NULL, cidade VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrato (id INT AUTO_INCREMENT NOT NULL, contratante_id INT NOT NULL, contratado_id INT NOT NULL, data VARCHAR(30) NOT NULL, imagem VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6669652390376976 (contratante_id), UNIQUE INDEX UNIQ_6669652394E7D2FC (contratado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clausula ADD CONSTRAINT FK_5D873D4C70AE7BF1 FOREIGN KEY (contrato_id) REFERENCES contrato (id)');
        $this->addSql('ALTER TABLE contrato ADD CONSTRAINT FK_6669652390376976 FOREIGN KEY (contratante_id) REFERENCES contratante (id)');
        $this->addSql('ALTER TABLE contrato ADD CONSTRAINT FK_6669652394E7D2FC FOREIGN KEY (contratado_id) REFERENCES contratado (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clausula DROP FOREIGN KEY FK_5D873D4C70AE7BF1');
        $this->addSql('ALTER TABLE contrato DROP FOREIGN KEY FK_6669652390376976');
        $this->addSql('ALTER TABLE contrato DROP FOREIGN KEY FK_6669652394E7D2FC');
        $this->addSql('DROP TABLE clausula');
        $this->addSql('DROP TABLE contratado');
        $this->addSql('DROP TABLE contratante');
        $this->addSql('DROP TABLE contrato');
    }
}
