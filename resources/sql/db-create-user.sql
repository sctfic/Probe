// creation de notre utilisateur principal
CREATE USER 'probe'@'localhost' IDENTIFIED BY  '***';
GRANT USAGE ON * . * TO  'probe'@'localhost' IDENTIFIED BY  '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
CREATE DATABASE IF NOT EXISTS  `probe` ;
GRANT ALL PRIVILEGES ON  `probe` . * TO  'probe'@'localhost';

