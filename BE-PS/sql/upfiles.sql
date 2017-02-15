USE be_ps;

CREATE TABLE upfiles
(
  file_id INT(9) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  file_path VARCHAR(50) NOT NULL ,
  file_owner CHAR(16) NOT NULL ,
  file_time DATE NOT NULL ,
  file_classification CHAR(10) NOT NULL ,
  file_discription VARCHAR(255) NOT NULL
) ENGINE = INNODB;