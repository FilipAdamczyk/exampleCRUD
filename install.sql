CREATE DATABASE `crud`;
USE `crud`;
-- CREATE USER 'cruduser'@'localhost' IDENTIFIED BY '#secure_user_pass#';
-- GRANT ALL PRIVILEGES ON *.* TO 'cruduser'@'localhost' WITH GRANT OPTION;
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `surname` VARCHAR(255),
    `telephone` VARCHAR(30),
    PRIMARY KEY (`id`)
)
ENGINE InnoDB DEFAULT COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `users_addresses` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `street` VARCHAR(255),
    `number` VARCHAR(30),
    `city` VARCHAR(255),
    `postal_code` VARCHAR(30),
    PRIMARY KEY (`id`),
    UNIQUE KEY (`user_id`)
)
ENGINE InnoDB DEFAULT COLLATE utf8_general_ci;