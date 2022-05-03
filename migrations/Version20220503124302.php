<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD:migrations/Version20220503124541.php
final class Version20220503124541 extends AbstractMigration
=======
final class Version20220503124302 extends AbstractMigration
>>>>>>> 19c1d84ec4fd4ebc76f291ebca76b2770943b93e:migrations/Version20220503124302.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20220503124541.php
        $this->addSql('ALTER TABLE user ADD email VARCHAR(255) NOT NULL');
=======
        $this->addSql('ALTER TABLE user ADD email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
>>>>>>> 19c1d84ec4fd4ebc76f291ebca76b2770943b93e:migrations/Version20220503124302.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20220503124541.php
=======
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
>>>>>>> 19c1d84ec4fd4ebc76f291ebca76b2770943b93e:migrations/Version20220503124302.php
        $this->addSql('ALTER TABLE user DROP email');
    }
}
