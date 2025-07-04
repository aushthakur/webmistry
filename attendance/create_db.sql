CREATE DATABASE IF NOT EXISTS db_register;
USE db_register;

CREATE TABLE IF NOT EXISTS registration (
  first_name VARCHAR(20) NOT NULL,
  last_name VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL PRIMARY KEY,
  password VARCHAR(20) NOT NULL,
  mobile BIGINT(15) NOT NULL,
  city VARCHAR(50) NOT NULL,
  address VARCHAR(200) NOT NULL
);

INSERT INTO registration VALUES ('Umesh', 'Rana', 'umesh.rana0269@gmail.com', '12', 7631200530, 'New Delhi', 'new delhi');

CREATE TABLE IF NOT EXISTS attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100),
  login_time DATETIME,
  break_time DATETIME,
  continue_time DATETIME,
  logout_time DATETIME,
  total_hours DECIMAL(5,2)
);