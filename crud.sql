
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT curtime()
)

-- adding a reset_token column to the database

ALTER TABLE `users`
ADD COLUMN `reset_token` VARCHAR(64) DEFAULT NULL;
ADD token_expire DATETIME DEFAULT NULL;