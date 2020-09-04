CREATE DATABASE dvdDatabase;

use dvdDatabase;

CREATE TABLE dvds (
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	title VARCHAR(50) NOT NULL,
    image VARCHAR(50),
	director VARCHAR(50),
	starring VARCHAR(100),
    genre VARCHAR(50),
    tv LONGTEXT,
    season INT(2),
    releasedate YEAR(4),
	date TIMESTAMP
);

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);