CREATE DATABASE 'inventory';
CREATE TABLE `users` (
    `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL UNIQUE ,
    `email` VARCHAR(225) NOT NULL UNIQUE,
    `password` VARCHAR(225) NOT NULL,
    `role` ENUM('Admin','Other'),
    `register_at` DATE NOT NULL,
    `last_login` DATE,
    `notes` TEXT
    );



    -- //getting all user;
    SELECT * FROM `users`;

    -- //inseting user
    INSERT INTO `users` (`name`, `email`, `password`, `role`, `register_at`) VALUES (:name , :email, :password, :role, date("Y/m/d"));

    -- //updating login time
    UPDATE `users` SET `last_login` = $login_at WHERE `id` = $id;


    -- For CATEGORIES

    CREATE TABLE `categories`(
    `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `parent_cat` INT UNSIGNED NOT NULL, 
    `category_name` VARCHAR(225) NOT NULL UNIQUE,
    `status` ENUM('1','0') NOT NUll DEFAULt 1
    );

    -- Add categories

    INSERT INTO `categories` (`parent_cat`,`category_name`) VALUES (:parent_cat, :category_name);
    -- table  တစ်ခုတည်းကိုပဲ join ပြီးထုတ်တာ။
    select c.category_name,p.category_name as parent_category,p.status from categories c left join categories p on c.parent_cat = p.id;

    select c.parent_cat,c.category_name as parent,p.category_name as category,p.status from categories p left join  categories c on c.id = p.parent_cat;



    -- For Brand
    CREATE TABLE `brands`(
        `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `b_name` VARCHAR(225) NOT NULL UNIQUE,
        `status`ENUM('1','0') NOT NUll DEFAULt 1
        );

    -- For Product
    CREATE TABLE `products` (
    `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `brand_id` INT UNSIGNED NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    `product_name` VARCHAR(255) NOT NULL UNIQUE,
    `price` INT UNSIGNED NOT NULL,
    `stock`INT UNSIGNED DEFAULT 0,
    `img` TEXT,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME,
    `status` ENUM('1', '0') NOT NULL DEFAULT '1',
    FOREIGN KEY (`brand_id`) REFERENCES `brands`(`id`),
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
);

    -- Create product
    INSERT INTO `products` (`brand_id`, `category_id`, `product_name`, `price`, `stock`, `created_at`) VALUES
    (:brand_id, :category_id, :product_name, :price, :stock, NOW());

    SELECT `product_name`,`category_name`,`b_name`,`price`,`stock`,`updated_at`,`created_at`,`p.status` FROM `products`,`categories`,`brands` WHERE `p.brand_id` = `b.id`;

    SELECT 
    p.id,
    p.product_name,
    c.category_name,
    b.b_name,
    p.price,
    p.stock,
    p.img,
    p.created_at,
    p.updated_at,
    p.status
FROM 
    products p 
JOIN 
    categories c ON p.category_id = c.id 
JOIN 
    brands b ON p.brand_id = b.id LIMIT 0,10;


    -- Invoice
    CREATE TABLE `invoice`(
        `invoice_no` INT UNSIGNED,
        `customer_name` VARCHAR(225) NOT NULL,
        `order_date` DATE NOT NULL,
        `sub_total` DOUBLE NOT NULL,
        `tax` DOUBLE NOT NULL,
        `discount` DOUBLE NOT NULL,
        `net_total` DOUBLE NOT NULL,
        `paid` DOUBLE NOT NULL,
        `due` DOUBLE NOT NULL,
        `payment_type` TEXT(20) NOT NULL
    );

    CREATE TABLE `invoice_details`(
        `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        `invoice_no` INT NOT NULL,
        `product_name` VARCHAR(100) NOT NUll,
        `price` DOUBLE NOT NULL,
        `qty` INT NOT NULL
    )

    select  order_date, invoice.invoice_no, customer_name, sub_total, product_name, qty,  tax, paid,  price from `invoice` right join `invoice_details` on invoice_details.invoice_no = invoice.invoice_no;


    -- Adding Column
    -- ALTER TABLE `invoice` ADD `changes` INT DEFAULT 0;