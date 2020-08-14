CREATE DATABASE dvdDatabase; /* ben_test */

use dvdDatabase;

CREATE TABLE dvds ( /* works */
	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	title VARCHAR(50) NOT NULL, /* artistname */
    image VARCHAR(50), /* NEW */
	director VARCHAR(30), /* worktitle */
	starring VARCHAR(50), /* workdate */
    genre VARCHAR(15), /* worktype */
    tv BOOLEAN(1), /* NEW */
    season INT(2), /* NEW */
    releasedate INT(4) UNSIGNED, /* NEW */
	date TIMESTAMP /* date */
);