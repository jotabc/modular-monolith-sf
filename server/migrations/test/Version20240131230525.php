<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131230525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables and its relationships';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                CREATE TABLE `customer_db_test`.`customer` (
                    `id` CHAR(36) PRIMARY KEY NOT NULL,
                    `name` VARCHAR(100) DEFAULT NULL,
                    `email` VARCHAR(100) DEFAULT NULL UNIQUE,
                    `address` VARCHAR(100) DEFAULT NULL,
                    `age` SMALLINT NOT NULL,
                    `employee_id` CHAR(36) NOT NULL,
                    INDEX IDX_customer_name (`name`),
                    INDEX IDX_employee_id (`employee_id`)
                );

                CREATE TABLE `employee_db_test`.`employee` (
                    `id` CHAR(36) PRIMARY KEY NOT NULL,
                    `name` VARCHAR(50) DEFAULT NULL,
                    `email` VARCHAR(100) DEFAULT NULL UNIQUE,
                    `password` VARCHAR(250) DEFAULT NULL,
                    INDEX IDX_employee_name (`name`)
                );

                CREATE TABLE `rental_db_test`.`car` (
                    `id` CHAR(36) PRIMARY KEY NOT NULL,
                    `brand` VARCHAR(50) DEFAULT NULL,
                    `model` VARCHAR(50) DEFAULT NULL,
                    `color` VARCHAR(50) DEFAULT NULL,
                    INDEX IDX_car_brand (`brand`),
                    INDEX IDX_car_model (`model`),
                    INDEX IDX_car_color (`color`)
                );

                CREATE TABLE `rental_db_test`.`rental` (
                    `id` CHAR(36) PRIMARY KEY NOT NULL,
                    `customer_id` CHAR(36) NOT NULL,
                    `employee_id` CHAR(36) NOT NULL,
                    `car_id` CHAR(36) NOT NULL,
                    `start_date` DATETIME DEFAULT NULL,
                    `end_date` DATETIME DEFAULT NULL,
                    INDEX IDX_rental_customer_id (`customer_id`),
                    INDEX IDX_rental_employee_id (`employee_id`),
                    INDEX IDX_rental_car_id (`car_id`),
                    CONSTRAINT FK_rental_car_id FOREIGN KEY (`car_id`) REFERENCES `rental_db`.`car`(`id`) ON UPDATE CASCADE ON DELETE CASCADE 
                );
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                DROP TABLE `rental_db_test`.`rental`;
                DROP TABLE `rental_db_test`.`car`;
                DROP TABLE `customer_db_test`.`customer`;
                DROP TABLE `employee_db_test`.`employee`;
            SQL
        );
    }
}
