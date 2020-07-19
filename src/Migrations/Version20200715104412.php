<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200715104412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_article DROP FOREIGN KEY FK_F9E0C661126F525E');
        $this->addSql('DROP INDEX IDX_F9E0C661126F525E ON cart_article');
        $this->addSql('ALTER TABLE cart_article CHANGE item_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_article ADD CONSTRAINT FK_F9E0C6617294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_F9E0C6617294869C ON cart_article (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_article DROP FOREIGN KEY FK_F9E0C6617294869C');
        $this->addSql('DROP INDEX IDX_F9E0C6617294869C ON cart_article');
        $this->addSql('ALTER TABLE cart_article CHANGE article_id item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_article ADD CONSTRAINT FK_F9E0C661126F525E FOREIGN KEY (item_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_F9E0C661126F525E ON cart_article (item_id)');
    }
}
