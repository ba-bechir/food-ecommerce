<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200715105817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E5F6001E');
        $this->addSql('DROP INDEX IDX_8D93D649E5F6001E ON user');
        $this->addSql('ALTER TABLE user CHANGE cartarticle_id cart_article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64912FEF66E FOREIGN KEY (cart_article_id) REFERENCES cart_article (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64912FEF66E ON user (cart_article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64912FEF66E');
        $this->addSql('DROP INDEX IDX_8D93D64912FEF66E ON user');
        $this->addSql('ALTER TABLE user CHANGE cart_article_id cartarticle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E5F6001E FOREIGN KEY (cartarticle_id) REFERENCES cart_article (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649E5F6001E ON user (cartarticle_id)');
    }
}
