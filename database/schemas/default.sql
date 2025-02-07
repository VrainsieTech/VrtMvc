CREATE TABLE IF NOT EXISTS users(
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL,
	phone VARCHAR(15) NOT NULL,
	email VARCHAR(100) NOT NULL,
	frname VARCHAR(50) NOT NULL default 'notset',
	lsname VARCHAR(50) NOT NULL default 'notset',
	referrer VARCHAR(50) NOT NULL default 'SYSTEM',
	lastactivity VARCHAR(15) NOT NULL,
	created_at VARCHAR(15) NOT NULL,
	updated_at VARCHAR(15) NOT NULL,
	autodeletes VARCHAR(15) NOT NULL default 'notset',
	state ENUM('valid','active','inactive','banned','suspended') NOT NULL default 'valid',
	password VARCHAR(100) NOT NULL,

	PRIMARY KEY id
);

CREATE TABLE IF NOT EXISTS resets(
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	token VARCHAR(50) NOT NULL,
	requests INT NOT NULL,
	created_at VARCHAR(15) NOT NULL,
	expires_at VARCHAR(15) NOT NULL,

	PRIMARY KEY id,
	FOREIGN KEY user_id REFERENCES users(id) ON DELETE CASCADE
);