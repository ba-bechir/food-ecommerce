<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200715110342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_article ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_article ADD CONSTRAINT FK_F9E0C661A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F9E0C661A76ED395 ON cart_article (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64912FEF66E');
        $this->addSql('DROP INDEX IDX_8D93D64912FEF66E ON user');
        $this->addSql('ALTER TABLE user DROP cart_article_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_article DROP FOREIGN KEY FK_F9E0C661A76ED395');
        $this->addSql('DROP INDEX IDX_F9E0C661A76ED395 ON cart_article');
        $this->addSql('ALTER TABLE cart_article DROP user_id');
        $this->addSql('ALTER TABLE user ADD cart_article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64912FEF66E FOREIGN KEY (cart_article_id) REFERENCES cart_article (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64912FEF66E ON user (cart_article_id)');
    }
}
