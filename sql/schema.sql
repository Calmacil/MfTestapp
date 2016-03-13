-- Database

DROP TABLE IF EXISTS `users_roles`;
DROP TABLE IF EXISTS `role`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(32) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `salt` VARCHAR(128) NOT NULL,
  `email` VARCHAR(64) DEFAULT NULL,
  `role` ENUM('MEMBER','ADMIN') DEFAULT 'MEMBER',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE InnoDB CHARSET UTF8;

CREATE TABLE `role` (
  `role_id` TINYINT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE InnoDB CHARSET UTF8;

CREATE TABLE `users_roles` (
  `user_id` INT NOT NULL,
  `role_id` TINYINT NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
  FOREIGN KEY (`role_id`) REFERENCES `role`(`role_id`),
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE InnoDB CHARSET UTF8;

-- password:
-- - admin 'admin'
-- - member 'test'
INSERT INTO `users` (`username`, `password`, `salt`, `created_at`) VALUES
  ('admin', '291c55bd5f735359196614f3fd76a5a862d6e3fc8e0b33c03fb87c3a9faf00da62dbbbe02da78315872cb52c279b68d9f28763672269bc67a19213fe81215347', '123456', CURRENT_TIME),
  ('member', 'e7352c3a01c2dee15d155bf5a963d3eaee01694bb1385985fef47aa3aadafb8d938cc96cb462aad8843e57357c0ab50340a3fa3c24d0303afc80d90480df13f8', '678903', CURRENT_TIME);

INSERT INTO `role` (`name`) VALUES ('MEMBER'),('ADMIN');

INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES (1, 1), (1, 2), (2, 1);
