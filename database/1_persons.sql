CREATE TABLE persons (
    id          int auto_increment primary key,
    email       varchar(255),
    first_name  varchar(255),
    last_name   varchar(255),
    phone       varchar(255) null
) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;