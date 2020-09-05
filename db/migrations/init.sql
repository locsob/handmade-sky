CREATE TABLE users (
                       id INTEGER PRIMARY KEY,
                       email varchar(255) NOT NULL UNIQUE,
                       password varchar(255) NOT NULL
)
