CREATE TABLE persons (
    id          int auto_increment primary key,
    email       varchar(255),
    first_name  varchar(255),
    last_name   varchar(255),
    phone       varchar(255) null
);