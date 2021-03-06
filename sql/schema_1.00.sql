# The users table maintains the twitter data for all user's who have accessed the database
CREATE TABLE IF NOT EXISTS `tbl_users` (
	`user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`twitter_id` BIGINT(14) UNSIGNED NOT NULL,
	`auth_token` VARCHAR(60),
	`auth_token_secret` VARCHAR(42),
	PRIMARY KEY (`user_id`),
	UNIQUE KEY (`twitter_id`)
);

# Each user has many contacts, stored in this contacts table.
CREATE TABLE IF NOT EXISTS `tbl_contacts` (
	`contact_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`owner_id` INT UNSIGNED NOT NULL,
	`name` VARCHAR(42) NOT NULL,
	`phone` VARCHAR(20) NULL,
	`twitter` VARCHAR(17) NULL,
	PRIMARY KEY (`contact_id`),
	KEY (`owner_id`)
);

# This table is very active and manages all active user sessions. A user may 
# have several sessions active on multiple devices.
CREATE TABLE IF NOT EXISTS `tbl_sessions` (
	`session_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`token` VARCHAR(32) NOT NULL,
	`nonce` VARCHAR(32) NOT NULL,
	`expires` DATETIME NOT NULL,
	PRIMARY KEY (`session_id`),
	KEY (`user_id`, `token`)
);