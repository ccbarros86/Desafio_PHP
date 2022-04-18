USE app_db;

CREATE TABLE IF NOT EXISTS usuarios (
  id smallint AUTO_INCREMENT PRIMARY KEY,
  nome varchar(50) DEFAULT NULL,
  sobrenome varchar(50) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  idade smallint DEFAULT NULL,
  pw varchar(255) DEFAULT NULL
);