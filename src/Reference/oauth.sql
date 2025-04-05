-- sales_manager.oauth_tokens definition

CREATE TABLE `oauth_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `access_token` text COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `refresh_token` text COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_ja_0900_as_cs;

