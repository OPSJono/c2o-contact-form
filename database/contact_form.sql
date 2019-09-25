CREATE TABLE contact_form
(
    id         int auto_increment primary key,
    category_id     int,
    email      varchar(255) null,
    first_name varchar(255) null,
    last_name  varchar(255) null,
    phone      varchar(255) null,
    CONSTRAINT fk_category_id FOREIGN KEY (category_id) REFERENCES categories(id)
);