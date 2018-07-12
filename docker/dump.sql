CREATE TABLE IF NOT EXISTS homestead.urls (
    id int NOT NULL AUTO_INCREMENT,
    url varchar(255) NOT NULL,
    code char(5) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY url (url(255)),
    UNIQUE KEY code (code(5))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;