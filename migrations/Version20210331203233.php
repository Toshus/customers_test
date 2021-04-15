<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331203233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, gender VARCHAR(10) DEFAULT NULL, name_title VARCHAR(10) DEFAULT NULL, first_name VARCHAR(64) NOT NULL, last_name VARCHAR(64) NOT NULL, street VARCHAR(128) DEFAULT NULL, city VARCHAR(128) DEFAULT NULL, state VARCHAR(128) DEFAULT NULL, country VARCHAR(128) DEFAULT NULL, postcode BIGINT DEFAULT NULL, latitude VARCHAR(12) DEFAULT NULL, longitude VARCHAR(12) DEFAULT NULL, email VARCHAR(256) NOT NULL, uuid VARCHAR(36) NOT NULL, username VARCHAR(64) NOT NULL, password VARCHAR(64) NOT NULL, salt VARCHAR(64) NOT NULL, birthday DATETIME DEFAULT NULL, registered DATETIME NOT NULL, phone VARCHAR(20) DEFAULT NULL, cell VARCHAR(20) DEFAULT NULL, id_name VARCHAR(10) DEFAULT NULL, id_value VARCHAR(10) DEFAULT NULL, picture_lg VARCHAR(256) DEFAULT NULL, picture_med VARCHAR(256) DEFAULT NULL, picture_thumb VARCHAR(256) DEFAULT NULL, nationality VARCHAR(2) DEFAULT NULL, UNIQUE INDEX UNIQ_81398E09E7927C74 (email), INDEX idx_customer_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE customer');
    }
}
