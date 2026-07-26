CREATE TABLE IF NOT EXISTS `websites` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150),
    `domain` VARCHAR(255),
    `code_script` VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS `pages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150),
    `route` VARCHAR(255),
    `visitor_id` VARCHAR(255),
    `website_id` INT,
    CONSTRAINT fk_website_pages FOREIGN KEY (`website_id`) REFERENCES `websites`(`id`)
);