<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509192840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dishes (id INT AUTO_INCREMENT NOT NULL, parent_category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, price INT NOT NULL, INDEX IDX_584DD35D796A8F92 (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dishes_categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formulas (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_81D64DE5CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, src VARCHAR(255) NOT NULL, title VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menus (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, menu_entry VARCHAR(255) DEFAULT NULL, menu_main_course VARCHAR(255) DEFAULT NULL, menu_dessert VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, reservation_name VARCHAR(100) NOT NULL, reservation_phone VARCHAR(15) NOT NULL, guests_number INT NOT NULL, date_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4DA239A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurants (id INT AUTO_INCREMENT NOT NULL, guest_threshold SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedules (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(10) DEFAULT NULL, opening_hour TIME NOT NULL, closing_hour TIME NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tables (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, restaurant_id INT NOT NULL, reserved_number SMALLINT NOT NULL, is_free TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_84470221B83297E7 (reservation_id), INDEX IDX_84470221B1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, allergies LONGTEXT DEFAULT NULL, default_guests_number SMALLINT DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dishes ADD CONSTRAINT FK_584DD35D796A8F92 FOREIGN KEY (parent_category_id) REFERENCES dishes_categories (id)');
        $this->addSql('ALTER TABLE formulas ADD CONSTRAINT FK_81D64DE5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menus (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tables ADD CONSTRAINT FK_84470221B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE tables ADD CONSTRAINT FK_84470221B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dishes DROP FOREIGN KEY FK_584DD35D796A8F92');
        $this->addSql('ALTER TABLE formulas DROP FOREIGN KEY FK_81D64DE5CCD7E912');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('ALTER TABLE tables DROP FOREIGN KEY FK_84470221B83297E7');
        $this->addSql('ALTER TABLE tables DROP FOREIGN KEY FK_84470221B1E7706E');
        $this->addSql('DROP TABLE dishes');
        $this->addSql('DROP TABLE dishes_categories');
        $this->addSql('DROP TABLE formulas');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE menus');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE restaurants');
        $this->addSql('DROP TABLE schedules');
        $this->addSql('DROP TABLE tables');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
