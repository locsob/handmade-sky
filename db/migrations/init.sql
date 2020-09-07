CREATE TABLE users (
                       id INTEGER PRIMARY KEY,
                       name varchar(255) NOT NULL UNIQUE,
                       password varchar(255) NOT NULL,
                       activated bool NOT NULL,
                       activation_code varchar(255)
)
