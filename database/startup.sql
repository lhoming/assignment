CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL,
    address VARCHAR(255) NULL,
    balance INT NULL,
    token VARCHAR(255) NULL
);

-- Insert the admin user
INSERT INTO users (name, username, email, password, role, address, balance, token)
VALUES ('Admin Admin', 'admin', 'bibekbasnet2013@gmail.com', '$2y$10$KAqiEFDcH7NIbREbTtHOxeV5DgsShlXZigA9dym6TToKmzqV4Amju', 'admin', '252 Cambridge Street, Warrane, TAS,7018, Australia', 500, null);

-- Insert a regular user
INSERT INTO users (name, username, email, password, role, address, balance, token)
VALUES ('User User', 'user', 'user@example.com', '$2y$10$KAqiEFDcH7NIbREbTtHOxeV5DgsShlXZigA9dym6TToKmzqV4Amju', 'user', '252 Cambridge Street, Warrane, TAS,7018, Australia', 500, null);
