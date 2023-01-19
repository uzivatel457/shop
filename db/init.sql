CREATE TABLE `user` (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`code` varchar(7) NOT NULL UNIQUE,
	`name` varchar(50) NOT NULL,
	`surname` varchar(50) NOT NULL,
	`email` varchar(320) NOT NULL UNIQUE,
	`password` varchar(60) NOT NULL,
	`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `product` (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` varchar(100) NOT NULL,
	`price` double NOT NULL,
	`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `order` (
	 `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	 `user_id` int NOT NULL,
	 `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 `processed_at` datetime NULL,
	 FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE `order_item` (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`order_id` int NOT NULL,
	`product_id` int NOT NULL,
	`buy_price` double NOT NULL,
	`quantity` int NOT NULL,
	FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
	FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO `product` (`name`, `price`, `created_at`)
VALUES
	('Pencil', '4', now()),
	('Binder', '3.2', now()),
	('Pen', '2.7', now())
;
