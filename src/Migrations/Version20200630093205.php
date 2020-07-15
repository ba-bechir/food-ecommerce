<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200630093205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B77294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_BA388B77294869C ON cart (article_id)');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E661AD5CDBF');
        $this->addSql('DROP INDEX IDX_23A0E661AD5CDBF ON article');
        $this->addSql('ALTER TABLE article DROP cart_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article ADD cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E661AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_23A0E661AD5CDBF ON article (cart_id)');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B77294869C');
        $this->addSql('DROP INDEX IDX_BA388B77294869C ON cart');
        $this->addSql('ALTER TABLE cart DROP article_id');
    }
}
