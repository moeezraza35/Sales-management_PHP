CREATE TABLE `price` (`id` INT,`name` TINYTEXT,`quantity` INT,`purchase_price` FLOAT,PRIMARY KEY (`id`));
CREATE TABLE `cart` (`id` INT,`product` INT,`quantity` INT,`price` FLOAT,PRIMARY KEY (`id`));
CREATE TABLE `sales` (`sr` INT,`product` INT,`price` FLOAT,`quantity` INT,`date` DATE,PRIMARY KEY (`sr`));