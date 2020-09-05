CREATE TABLE users (
            id INT AUTO_INCREMENT,
            email varchar(255) NOT NULL UNIQUE,
            password varchar(255) NOT NULL
)
