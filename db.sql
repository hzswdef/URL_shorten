CREATE TABLE `shorten urls` (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    url CHAR(6),
    point VARCHAR(256),
    token CHAR(16)
)

CREATE TABLE `tokens` (
    token CHAR(16) PRIMARY KEY,
    used INT(11) UNSIGNED
)