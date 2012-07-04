// creation de notre utilisateur principal
CREATE USER 'wswds'@'localhost' IDENTIFIED BY  '***';
GRANT USAGE ON * . * TO  'wswds'@'localhost' IDENTIFIED BY  '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
CREATE DATABASE IF NOT EXISTS  `wswds` ;
GRANT ALL PRIVILEGES ON  `wswds` . * TO  'wswds'@'localhost';

