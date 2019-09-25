CREATE TABLE contact_form
(
    id         int auto_increment primary key,
    email      varchar(255) null,
    first_name varchar(255) null,
    last_name  varchar(255) null,
    reason     varchar(255) null,
    phone      varchar(255) null
);